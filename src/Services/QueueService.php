<?php

namespace RegalWings\QbwcLaravel\Services;

use RegalWings\QbwcLaravel\Models\Queue;
use RegalWings\QbwcLaravel\Models\Task;
use RegalWings\QbwcLaravel\Models\TaskConfig;
use RegalWings\QbwcLaravel\StructType\Queries\BillQuery;
use RegalWings\QbwcLaravel\StructType\Queries\InvoiceQuery;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class QueueService
{
    protected $queue;
    protected $file;
    protected $ticket;
    protected $queueName;
    protected $initialQueueSize;
    protected $startOfDay;

    public function __construct($ticket, $queueName, $file = null)
    {
        $this->ticket = $ticket;
        $this->queueName = $queueName;
        $this->file = $file;
        $this->startOfDay = Carbon::now()->startOfDay();
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
                    'file' => $this->file,
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

                $this->queue->total_tasks = $taskConfigs->count();
                $this->queue->save();

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
            return Task::on('qbwc_queue')
                ->where('queue_id', $this->queue->id)
                ->where('status', 'pending')
                ->orWhere('queue_id', $this->queue->id)
                ->where('status', 'processing')
                ->count();
        }

        return 0;
    }

    public function getPercentComplete()
    {
        $remainingTasks = $this->getRemainingTasks();
        $task = $this->getCurrentTask();

        if ($this->initialQueueSize > 0) {

            $taskPercentage = 100 - (($remainingTasks / $this->initialQueueSize) * 100);

            if ($task && $task->iterator == 'Continue') {
                $totalIterations = $task->loops_remaining + $task->loop_count;
                $iterationPercentage = ($task->loop_count / $totalIterations);

                return ((($iterationPercentage / $remainingTasks) * $totalIterations) + $taskPercentage);
            }

            return $taskPercentage;
        }

        return 100;
    }

    public function getLastRun()
    {
        try {
            $lastQueue = Queue::on('qbwc_queue')
                ->where('name', $this->queueName)
                ->when($this->file, function ($query) {
                    return $query->where('file', $this->file);
                })
                ->where('initialized', false)
                ->where('tasks_completed', '>', 0)
                ->where('tasks_failed', '=', 0)
                ->whereNotNull('completed_at')
                ->orderBy('completed_at', 'desc')
                ->first();

            return new Carbon($lastQueue?->initialized_at ?? $this->startOfDay);
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
                    ->orWhere('queue_id', $this->queue->id)
                    ->where('status', 'processing')
                    ->where('iterator', 'Continue')
                    ->orderBy('order')
                    ->first();

                if ($task) {
                    $taskClass = $task->task_class;
                    $taskParams = $task->task_params;

                    if ($task->status == 'pending') {
                        $task->started_at = Carbon::now();
                        $task->status = 'processing';
                    }

                    $iterator = null;
                    $iteratorId = null;
                    $loopCount = null;

                    if ($task->iterator == 'Start' || $task->iterator == 'Continue') {
                        $iterator = $task->iterator;
                        $iteratorId = $task->iterator_id;
                        $loopCount = $task->loop_count;
                    }

                    $task->save();

                    return new $taskClass($taskParams, null, $loopCount, $iterator, $iteratorId);
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
            switch ($key) {
                case 'ModifiedDateRangeFilter':
                    $this->setModifiedDateRangeFilter($query, $value);
                    break;
                case 'TxnDateRangeFilter':
                    $this->setTxnDateRangeFilter($query, $value);
                    break;
                case 'FromModifiedDate':
                    $this->setFromModifiedDate($query, $value);
                    break;
                case 'ToModifiedDate':
                    $this->setToModifiedDate($query, $value);
                    break;
                case 'EntityFilter':
                    $this->setEntityFilter($query, $value);
                    break;
            }
        }

        return $query;
    }

    protected function setModifiedDateRangeFilter($query, $value)
    {
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

    protected function setTxnDateRangeFilter($query, $value)
    {
        if (isset($value['FromTxnDate']) && $value['FromTxnDate'] == '') {
            $query->setParameter(
                [
                    'TxnDateRangeFilter',
                    'FromTxnDate'
                ],
                $this->getLastRun()->format('Y-m-d')
            );
        }

        if (isset($value['ToTxnDate']) && $value['ToTxnDate'] == '') {
            $query->setParameter(
                [
                    'TxnDateRangeFilter',
                    'ToTxnDate'
                ],
                Carbon::now()->format('Y-m-d')
            );
        }
    }

    protected function setFromModifiedDate($query, $value)
    {
        if ($value == '') {
            $query->setParameter(
                'FromModifiedDate',
                $this->getLastRun()->format('Y-m-d\TH:i:s')
            );
        }
    }

    protected function setToModifiedDate($query, $value)
    {
        if ($value == '') {
            $query->setParameter(
                'ToModifiedDate',
                Carbon::now()->format('Y-m-d\TH:i:s')
            );
        }
    }

    protected function setEntityFilter($query, $value)
    {
        if (isset($value['ListID']) && $value['ListID'] == '') {
            if ($query instanceof BillQuery) {
                $listIds = config('qbwc.model_map.Vendor')::pluck('list_id')->unique();
            } elseif ($query instanceof InvoiceQuery) {
                $listIds = config('qbwc.model_map.Customer')::pluck('list_id')->unique();
            }

            $query->setParameter(
                [
                    'EntityFilter',
                    'ListID'
                ],
                $listIds->toArray()
            );
        }
    }

    public function updateTaskIterator($iteratorId, $remainingCount)
    {
        try {
            $task = Task::on('qbwc_queue')
                ->where('queue_id', $this->queue->id)
                ->where('iterator_id', $iteratorId)
                ->orWhere('queue_id', $this->queue->id)
                ->where('iterator', 'Start')
                ->where('status', 'processing')
                ->first();

            if ($task) {
                if ($task->iterator == 'Start') {
                    $task->iterator = 'Continue';
                    $task->iterator_id = $iteratorId;
                }

                $task->increment('loop_count');
                $task->loops_remaining = $remainingCount;

                if ($task->loops_remaining == 0) {
                    $task->iterator = 'End';
                    $task->status = 'completed';
                }

                $task->save();
            }
        } catch (\Exception $e) {
            Log::error("Failed to update task iterator: " . $e->getMessage());
        }
    }

    public function markTaskCompleted($task)
    {
        try {
            $task = Task::on('qbwc_queue')->find($task->id);
            $task->status = 'completed';
            $task->completed_at = Carbon::now()->format('Y-m-d H:i:s');
            $task->save();

            $this->queue->tasks_completed = $this->queue->tasks_completed + 1;
            $this->queue->save();
        } catch (\Exception $e) {
            Log::error("Failed to mark task as completed: " . $e->getMessage());
        }
    }

    public function markTaskFailed($task, $errorMessage)
    {
        try {
            $task = Task::on('qbwc_queue')->find($task->id);
            $task->status = 'failed';
            $task->error_message = $errorMessage;
            $task->save();

            $this->queue->tasks_failed = $this->queue->tasks_failed + 1;
            $this->queue->save();
            Log::error("Task failed: " . $errorMessage);
        } catch (\Exception $e) {
            Log::error("Failed to mark task as failed: " . $e->getMessage());
        }
    }

    public function markQueueCompleted()
    {
        try {
            $this->queue->initialized = false;
            $this->queue->completed_at = Carbon::now()->format('Y-m-d H:i:s');
            $this->queue->save();
        } catch (\Exception $e) {
            Log::error("Failed to mark queue as completed: " . $e->getMessage());
        }
    }

    public function markQueueFailed()
    {
        try {
            $this->queue->initialized = false;
            $this->queue->completed_at = Carbon::now()->format('Y-m-d H:i:s');
            $this->queue->save();

            // $this->queue->tasks_failed = $this->queue->tasks_failed + 1;
            // $this->queue->save();
        } catch (\Exception $e) {
            Log::error("Failed to mark queue as failed: " . $e->getMessage());
        }
    }
}
