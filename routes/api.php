<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Task Resources
Route::middleware('auth:api')->get('tasks', 'TaskController@index');
Route::middleware('auth:api')->post('tasks', 'TaskController@store');
Route::middleware('auth:api')->patch('tasks/{id}', 'TaskController@update');
Route::middleware('auth:api')->delete('tasks/{id}', 'TaskController@destroy');

//Switch task order
Route::middleware('auth:api')->patch('tasks/up/{id}', 'TaskController@orderUp');
Route::middleware('auth:api')->patch('tasks/down/{id}', 'TaskController@orderDown');

//Current task
Route::middleware('auth:api')->get('tasks/current', 'TaskController@currentTask');

//Mark As completed
Route::middleware('auth:api')->patch('task/mark/{id}', 'TaskController@markAsCompleted');
