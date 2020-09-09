<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DateTask extends Model
{
    public $table = 'date_task';

    protected $fillable = [
        'user_id', 'date_task',
    ];

    public function tasks(){
        return $this->hasMany(Task::class,'date_id');
    }

    // public function tasksfilter(){
    //     return $this->hasMany(Task::class,'date_id')->orderBy('minutes')->orderBy('seconds');
    // }

    public function task(){
        return $this->hasOne(Task::class,'date_id');
    }
}
