<?php

namespace AaronGRTech\QbwcLaravel\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $connection = 'qbwc_queue';
    protected $fillable = [
        'queue_id', 'task_class', 'task_params', 'order', 'status', 'error_message', 'started_at', 'completed_at'
    ];

    public function queue()
    {
        return $this->belongsTo(Queue::class);
    }
}