<?php

namespace AaronGRTech\QbwcLaravel\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskConfig extends Model
{
    use HasFactory;

    protected $connection = 'qbwc_queue';
    protected $fillable = ['user_id', 'queue_name', 'task_class', 'task_params', 'iterate', 'order'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
