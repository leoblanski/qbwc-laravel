<?php

namespace AaronGRTech\QbwcLaravel\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskConfig extends Model
{
    use HasFactory;

    protected $connection = 'qbwc_queue';
    protected $fillable = ['user_id', 'queue_name', 'task_class', 'task_params', 'order'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getTaskParamsAttribute()
    {
        return json_decode($this->attributes['task_params'], true);
    }
}
