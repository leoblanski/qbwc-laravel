<?php

namespace AaronGRTech\QbwcLaravel\Services;

use AaronGRTech\QbwcLaravel\Models\Queue;
use AaronGRTech\QbwcLaravel\Models\Task;
use AaronGRTech\QbwcLaravel\Models\TaskConfig;
use Carbon\Carbon;

class QueueService
{
    protected $queue;
    protected $queueName;
    protected $initialQueueSize;

    public function __construct($queueName)
    {
        $this->queueName = $queueName;
    }

    public function initializeQueue()
    {
        $this->queue = Queue::on('qbwc_queue')->create(
            [
                'name' => $this->queueName,
                'initialized' => true,
                'initialized_at' => Carbon::now(),
            ]
        );

        if ($this->queue->wasRecentlyCreated) {
            $taskConfigs = TaskConfig::on('qbwc_queue')
                                      ->where('queue_name', $this->queueName)
                                      ->orderBy('order')
                                      ->get();

            $this->queue->update(['total_tasks' => $taskConfigs->count()]);

            foreach ($taskConfigs as $taskConfig) {
                Task::on('qbwc_queue')->create([
                    'queue_id' => $this->queue->id,
                    'task_data' => $taskConfig->task_data,
                    'status' => 'pending',
                    'order' => $taskConfig->order,
                ]);
            }
        }

        $this->initialQueueSize = Task::on('qbwc_queue')->where('queue_id', $this->queue->id)->count();
    }

    public function getNextTask()
    {
        if ($this->queue && $this->queue->initialized) {
            return Task::on('qbwc_queue')
                        ->where('queue_id', $this->queue->id)
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

    public function getQueueId()
    {
        return $this->queue->id;
    }

    public function getInitialQueueSize()
    {
        return $this->initialQueueSize;
    }

    public function getRemainingTasks()
    {
        if ($this->queue) {
            return Task::on('qbwc_queue')->where('queue_id', $this->queue->id)->where('status', 'pending')->count();
        }

        return 0;
    }

    public function getPercentComplete()
    {
        $remainingTasks = $this->getRemainingTasks();

        if ($this->initialQueueSize > 0) {
            return 100 - (($remainingTasks / $this->initialQueueSize) * 100);
        }

        return 100;
    }
}
