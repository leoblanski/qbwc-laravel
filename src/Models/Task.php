<?php

namespace RegalWings\QbwcLaravel\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $connection = 'qbwc_queue';
    protected $fillable = [
        'queue_id',
        'task_class',
        'task_params',
        'iterator',
        'iterator_id',
        'loop_count',
        'loops_remaining',
        'order',
        'status',
        'error_message',
        'started_at',
        'completed_at'
    ];

    public function queue()
    {
        return $this->belongsTo(Queue::class);
    }

    public function getTaskParamsAttribute()
    {
        return json_decode($this->attributes['task_params'], true);
    }
}
