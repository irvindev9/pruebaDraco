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
        
        $task = new Task();
            $task->date_id = $dateTask->id;
            $task->title = $request['params']['title'];
            $task->description = $request['params']['description'];
            $task->minutes = $request['params']['minutes'];
            $task->seconds = $request['params']['seconds'];
        $task->save();

        return response("Success");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
