<?php

namespace AaronGRTech\QbwcLaravel\Services;

use AaronGRTech\QbwcLaravel\Models\Queue;
use AaronGRTech\QbwcLaravel\Models\Task;
use AaronGRTech\QbwcLaravel\Models\TaskConfig;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class QueueService
{
    protected $queue;
    protected $ticket;
    protected $queueName;
    protected $initialQueueSize;

    public function __construct($ticket, $queueName)
    {
        $this->queueName = $queueName;
    }

    public function initializeQueue()
    {
        try {
            $this->queue = Queue::on('qbwc_queue')->firstOrCreate(
                [
                    'ticket' => $this->ticket,
                    'initialized' => true,
                ],
                [
                    'name' => $this->queueName,
                    'ticket' => $this->ticket,
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
                        'task_class' => $taskConfig->task_class,
                        'task_params' => $taskConfig->task_params,
                        'iterator' => $taskConfig->iterate ? 'Start' : null,
                        'loop_count' => $taskConfig->iterate ? 1 : null,
                        'status' => 'pending',
                        'order' => $taskConfig->order,
                    ]);
                }
            }

            $this->initialQueueSize = Task::on('qbwc_queue')->where('queue_id', $this->queue->id)->count();
        } catch (\Exception $e) {
            Log::error("Failed to initialize queue: " . $e->getMessage());
        }
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

    public function getLastRun()
    {
        try {
            $lastQueue = Queue::on('qbwc_queue')
                              ->where('name', $this->queueName)
                              ->where('initialized', false)
                              ->where('tasks_completed', '>', 0)
                              ->whereNotNull('completed_at')
                              ->orderBy('completed_at', 'desc')
                              ->first();

            return new Carbon($lastQueue->initialized_at);
        } catch (\Exception $e) {
            Log::error("Failed to get last run: " . $e->getMessage());
        }

        return Carbon::now()->subHours(1)->toDateString();
    }

    public function getCurrentTask()
    {
        try {
            if ($this->queue && $this->queue->initialized) {
                return Task::on('qbwc_queue')
                    ->where('queue_id', $this->queue->id)
                    ->where('status', 'processing')
                    ->orderBy('order')
                    ->first();
            }
        } catch (\Exception $e) {
            Log::error("Failed to get current task: " . $e->getMessage());
        }

        return null;
    }

    public function getNextTask()
    {
        try {
            if ($this->queue && $this->queue->initialized) {
                $task = Task::on('qbwc_queue')
                    ->where('queue_id', $this->queue->id)
                    ->where('status', 'pending')
                    ->orderBy('order')
                    ->first();

                if ($task) {
                    $taskClass = $task->task_class;
                    $taskParams = $task->task_params;
                    $iterator = null;
                    $iteratorId = null;
                    $loopCount = null;

                    if ($task->iterator == 'Start' || $task->iterator == 'Continue') {
                        $iterator = $task->iterator;
                        $iteratorId = $task->iterator_id;
                        $loopCount = $task->loop_count;

                        $task->iterator = 'Continue';
                        $task->loop_count->increment();

                        if ($task->loops_remaining && $task->loops_remaining > 0) {
                            $task->loops_remaining->decrement();

                            if ($task->loops_remaining == 0) {
                                $task->status = 'completed';
                            }
                        }
                    }
                    

                    $task->started_at = Carbon::now();
                    $task->status = 'processing';
                    $task->save();
    
                    return new $taskClass($taskParams, $iterator, $iteratorId, $loopCount);
                }
            }
        } catch (\Exception $e) {
            Log::error("Failed to get next task: " . $e->getMessage());
        }

        return null;
    }

    public function setRuntimeValues($query)
    {
        foreach ($query->getParameters() as $key => $value) {
            if ($key === 'ModifiedDateRangeFilter') {
                if (isset($value['FromModifiedDate']) && $value['FromModifiedDate'] == '') {
                    $query->setParameter(
                        [
                            'ModifiedDateRangeFilter',
                            'FromModifiedDate'
                        ],
                        $this->getLastRun()->format('Y-m-d\TH:i:s')
                    );
                }

                if (isset($value['ToModifiedDate']) && $value['ToModifiedDate'] == '') {
                    $query->setParameter(
                        [
                            'ModifiedDateRangeFilter',
                            'ToModifiedDate'
                        ],
                        Carbon::now()->format('Y-m-d\TH:i:s')
                    );
                }
            }
        }        

        return $query;
    }

    public function markTaskCompleted(Task $task)
    {
        try {
            $task->update([
                'status' => 'completed',
                'completed_at' => Carbon::now(),
            ]);

            $queue = $task->queue;
            $queue->increment('tasks_completed');
        } catch (\Exception $e) {
            Log::error("Failed to mark task as completed: " . $e->getMessage());
        }
    }

    public function markTaskFailed(Task $task, $errorMessage)
    {
        try {
            $task->update([
                'status' => 'failed',
                'error_message' => $errorMessage,
            ]);

            $queue = $task->queue;
            $queue->increment('tasks_failed');
            Log::error("Task failed: " . $errorMessage);
        } catch (\Exception $e) {
            Log::error("Failed to mark task as failed: " . $e->getMessage());
        }
    }

    public function markQueueCompleted()
    {
        try {
            $this->queue->update(
                [
                    'initialized' => false,
                    'completed_at' => Carbon::now()
                ]
            );
        } catch (\Exception $e) {
            Log::error("Failed to mark queue as completed: " . $e->getMessage());
        }
    }
}
