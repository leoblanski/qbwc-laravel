<?php

namespace RegalWings\Qbwc\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Queue extends Model
{
    use HasFactory;

    protected $connection = 'qbwc_queue';
    protected $fillable = [
        'name',
        'file',
        'ticket',
        'initialized',
        'total_tasks',
        'tasks_completed',
        'tasks_failed',
        'initialized_at',
        'completed_at'
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
