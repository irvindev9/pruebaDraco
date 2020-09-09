<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\DateTask;
use App\Models\Task;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($day = 0)
    {
        $user = Auth::user();
        return view('home')->with(compact('user', 'day'));
    }

    public function chart($id = 0){

        $data = [0,0,0,0,0,0,0];

        $cont = 0;

        $day = DateTask::with(['tasks'])->find($id);

        if(isset($day)){
            for($cont = 0;$cont<7;$cont++){
                $yesterday = date("Y-m-d", strtotime( '-'.$cont.' days', strtotime($day->date_task) ) );
    
                $tasks = DateTask::with(['tasks' => function($q){
                    $q->where('completed',1);
                }])->where('date_task',$yesterday)->where('user_id', Auth::user()->id)->first();
    
                $total = 0;
    
                if(isset($tasks['tasks'])){
                    foreach($tasks['tasks'] as $task){
                        $total += $task->time_required;
                    }
                }
                $data[$cont] = $total;
            }
            $data = array_reverse($data);
        }

        return view('chart')->with(compact('data', 'day'));
    }

    public function fill(){
        $tasks = 50;

        $taskPerDay = 8;

        $days = 7;

        for($i=0;$i<$days;$i++){
            $yesterday = date("Y-m-d", strtotime( '-'.$i.' days') );

            $dateTask = DateTask::create(array('user_id' => Auth::user()->id, 'date_task' => $yesterday)); 

            for($j=0;$j<$taskPerDay;$j++){
                $task = new Task();
                    $task->date_id = $dateTask->id;
                    $task->title = 'Tarea '.($i+1).'-'.($j+1);
                    $task->description = 'Descripción '.($i+1).'-'.($j+1);
                    $time = random_int(30, 120);
                    $task->minutes = $time;
                    $task->seconds = 0;
                    $task->completed = ($j%2 == 0) ? 1 : 0;
                    if($j%2 == 0){
                        $task->time_required = $time * 0.8;
                    }
                    $task->order = $j + 1;
                $task->save();
            }
        }

        return redirect()->route('home');
    }
}
