<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DateTask;
use App\Models\Task;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $date = explode('T',$request->date);
        $date = $date[0];

        if($request->filter == "true"){
            $dateTask = DateTask::with(['tasks' => function($q){
                $q->where('completed',0)->orderByRaw('ABS(minutes) Desc, ABS(seconds) Desc');
            }])->where('user_id',$request->user()->id)->where('date_task', $date)->first();
        }else{
            $dateTask = DateTask::with(['tasks' => function($q){
                $q->where('completed',0)->orderBy('order');
            }])->where('user_id',$request->user()->id)->where('date_task', $date)->first();
        }

        return response($dateTask);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function currentTask(Request $request)
    {
        $date = explode('T',$request->date);
        $date = $date[0];
        
        if($request->filter == "true"){
            $dateTask = DateTask::with(['task' => function($q){
                $q->where('completed',0)->orderByRaw('ABS(minutes) Desc, ABS(seconds) Desc');
            }])->where('user_id',$request->user()->id)->where('date_task', $date)->first();
        }else{
            $dateTask = DateTask::with(['task' => function($q){
                $q->where('completed',0)->orderBy('order');
            }])->where('user_id',$request->user()->id)->where('date_task', $date)->first();
        }

        return response($dateTask);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $date = explode('T',$request['params']['date']);
        $date = $date[0];

        $dateTask = DateTask::firstOrCreate(array('user_id' => $request->user()->id, 'date_task' => $date)); 
        
        $lastTask = Task::where('date_id',$dateTask->id)->orderBy('order','desc')->first();
        
        $task = new Task();
            $task->date_id = $dateTask->id;
            $task->title = $request['params']['title'];
            $task->description = $request['params']['description'];
            $task->minutes = $request['params']['minutes'];
            $task->seconds = $request['params']['seconds'];
            $task->order = isset($lastTask->order) ? $lastTask->order + 1 : 1;
        $task->save();

        return response("Success");
    }


    public function orderUp(Request $request, $id)
    {
        $date = explode('T',$request['params']['date']);
        $date = $date[0];

        $dateTask = DateTask::with(['tasks' => function($q){
            $q->where('completed',0)->orderBy('order');
        }])->where('user_id',$request->user()->id)->where('date_task', $date)->first()->toArray();

        $upLevel = null;

        foreach($dateTask['tasks'] as $key => $task){
            if($task['id'] == $id){
                $upLevel = $key;
            }
        }

        // dd($upLevel);

        if(isset($dateTask['tasks'][$upLevel - 1])){
            $task1 = Task::find($dateTask['tasks'][$upLevel]['id']);
            $task2 = Task::find($dateTask['tasks'][$upLevel - 1]['id']);

            $order1 = $task1->order;
            $order2 = $task2->order;

            $task1->order = $order2;
            $task2->order = $order1;

            $task1->save();
            $task2->save();
        }

        return response([$request->all(), $id]);
    }


    public function orderDown(Request $request, $id)
    {
        $date = explode('T',$request['params']['date']);
        $date = $date[0];

        $dateTask = DateTask::with(['tasks' => function($q){
            $q->where('completed',0)->orderBy('order');
        }])->where('user_id',$request->user()->id)->where('date_task', $date)->first()->toArray();

        $upLevel = null;

        foreach($dateTask['tasks'] as $key => $task){
            if($task['id'] == $id){
                $upLevel = $key;
            }
        }

        if(isset($dateTask['tasks'][$upLevel + 1])){
            $task1 = Task::find($dateTask['tasks'][$upLevel]['id']);
            $task2 = Task::find($dateTask['tasks'][$upLevel + 1]['id']);

            $order1 = $task1->order;
            $order2 = $task2->order;

            $task1->order = $order2;
            $task2->order = $order1;

            $task1->save();
            $task2->save();
        }

        return response([$request->all(), $id]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $task = Task::find($id);
            $task->title = $request['params']['title'];
            $task->description = $request['params']['description'];
            $task->minutes = $request['params']['minutes'];
            $task->seconds = $request['params']['seconds'];
        $task->save();

        return response("Success");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Task::destroy($id);

        return response("Success");
    }

    public function markAsCompleted(Request $request, $id){

        $task = Task::find($id);
            $task->completed = 1;
            $task->time_required = $request['params']['timeRequired'];
        $task->save();
        
        return response("Success");
    }

    public function completedList(Request $request){
        $date = explode('T',$request->date);
        $date = $date[0];

        $dateTask = DateTask::with(['tasks' => function($q){
            $q->where('completed',1)->orderBy('order');
        }])->where('user_id',$request->user()->id)->where('date_task', $date)->first();

        return response($dateTask);
    }

    public function isEmpty(Request $request){
        $task = DateTask::where('user_id',$request->user()->id)->count();
        $empty = 0;

        if($task == 0){
            $empty = 1;
        }

        return response($empty);
    }
}
