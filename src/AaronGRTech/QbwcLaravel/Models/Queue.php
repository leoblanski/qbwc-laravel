<?php

namespace App\Models\Qbwc;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Queue extends Model
{
    use HasFactory;

    protected $connection = 'qbwc_queue';
    protected $fillable = [
        'name', 'initialized', 'total_tasks', 'tasks_completed', 'tasks_failed', 
        'initialized_at', 'completed_at'
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}

