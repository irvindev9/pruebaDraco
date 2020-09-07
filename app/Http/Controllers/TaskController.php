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

        $dateTask = DateTask::with(['tasks'])->where('user_id',$request->user()->id)->where('date_task', $date)->first();

        return response($dateTask);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

        $dateTask = DateTask::with(['tasks'])->where('user_id',$request->user()->id)->where('date_task', $date)->first()->toArray();

        $upLevel = null;

        foreach($dateTask['tasks'] as $key => $task){
            if($task['id'] == $id){
                $upLevel = $key;
            }
        }

        if(isset($dateTask['tasks'][$upLevel - 1])){
            dd('Hacer el cambio de $upLevel y $upLevel -1');
        }

        return response([$request->all(), $id]);
    }


    public function orderDown(Request $request, $id)
    {
        $date = explode('T',$request['params']['date']);
        $date = $date[0];

        $dateTask = DateTask::with(['tasks'])->where('user_id',$request->user()->id)->where('date_task', $date)->first()->toArray();

        $upLevel = null;

        foreach($dateTask['tasks'] as $key => $task){
            if($task['id'] == $id){
                $upLevel = $key;
            }
        }

        if(isset($dateTask['tasks'][$upLevel + 1])){
            dd('Hacer el cambio de $upLevel y $upLevel + 1');
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
}
