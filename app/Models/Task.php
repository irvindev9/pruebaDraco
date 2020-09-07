<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public $table = 'task';

    public function dateTask(){
        return $this->belongsTo(DateTask::class,Task::class);
    }
}
