<?php

namespace App\Services\Qbwc;

use App\Models\Qbwc\Queue;
use App\Models\Qbwc\Task;
use App\Models\Qbwc\TaskConfig;
use Carbon\Carbon;

class QueueService
{
    public function initializeQueue($name, $userId)
    {
        $queue = Queue::on('qbwc_queue')->firstOrCreate(['name' => $name], [
            'initialized' => true,
            'initialized_at' => Carbon::now(),
        ]);

        if ($queue->wasRecentlyCreated) {
            $taskConfigs = TaskConfig::on('qbwc_queue')
                                      ->where('queue_name', $name)
                                      ->where('user_id', $userId)
                                      ->orderBy('order')
                                      ->get();

            $queue->update(['total_tasks' => $taskConfigs->count()]);

            foreach ($taskConfigs as $taskConfig) {
                Task::on('qbwc_queue')->create([
                    'queue_id' => $queue->id,
                    'task_data' => $taskConfig->task_data,
                    'status' => 'pending',
                    'order' => $taskConfig->order,
                ]);
            }
        }
    }

    public function getNextTask($queueName)
    {
        $queue = Queue::on('qbwc_queue')->where('name', $queueName)->first();

        if ($queue && $queue->initialized) {
            return Task::on('qbwc_queue')
                        ->where('queue_id', $queue->id)
                        ->where('status', 'pending')
                        ->orderBy('order')
                        ->first();
        }

        return null;
    }

    public function markTaskCompleted(Task $task)
    {
        $task->update([
            'status' => 'completed',
            'completed_at' => Carbon::now(),
        ]);

        $queue = $task->queue;
        $queue->increment('tasks_completed');

        if ($queue->tasks()->where('status', 'pending')->doesntExist()) {
            $queue->update(['completed_at' => Carbon::now()]);
        }
    }

    public function markTaskFailed(Task $task, $errorMessage)
    {
        $task->update([
            'status' => 'failed',
            'error_message' => $errorMessage,
        ]);

        $queue = $task->queue;
        $queue->increment('tasks_failed');
    }
}
