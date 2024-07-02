<?php

namespace App\Models\Qbwc;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $connection = 'qbwc_queue';
    protected $fillable = [
        'qbwc_queue_id', 'task_data', 'status', 'order', 'error_message', 'started_at', 'completed_at'
    ];

    public function queue()
    {
        return $this->belongsTo(Queue::class);
    }
}
