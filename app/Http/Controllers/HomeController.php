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
// dd($day);
        if(isset($day)){
            for($cont = 0;$cont<7;$cont++){
                $yesterday = date("Y-m-d", strtotime( '-'.$cont.' days', strtotime($day->date_task) ) );
    
                $tasks = DateTask::with(['tasks' => function($q){
                    $q->where('completed',1);
                }])->where('date_task',$yesterday)->first();
    
                $total = 0;
    
                // dd($tasks['tasks']);
                if(isset($tasks['tasks'])){
                    foreach($tasks['tasks'] as $task){
                        $total += (($task->minutes * 60) + $task->seconds) / 60;
                    }
                }
    
                $data[$cont] = $total;
                
            }
            
    
            $data = array_reverse($data);
        }

        return view('chart')->with(compact('data', 'day'));
    }
}
