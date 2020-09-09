<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public $table = 'task';

    protected $casts = [
        'minutes' => 'integer',
        'seconds' => 'integer',
    ];

    public function dateTask(){
        return $this->belongsTo(DateTask::class,Task::class);
    }
}
