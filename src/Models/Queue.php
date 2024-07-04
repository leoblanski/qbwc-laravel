<?php

namespace AaronGRTech\QbwcLaravel\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Queue extends Model
{
    use HasFactory;

    protected $connection = 'qbwc_queue';
    protected $fillable = [
        'name', 'total_tasks', 'tasks_completed', 'tasks_failed', 
        'initialized_at', 'completed_at'
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}

