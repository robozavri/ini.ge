<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/user/confirmation/{code}', '\App\Http\Controllers\Auth\RegisterController@Confirmation')->name('registration_confirmation');
Route::post('/user/confirmation/', '\App\Http\Controllers\Auth\RegisterController@CodeConfirmation')->name('code_confirmation');
Route::get('/code/confirmation', '\App\Http\Controllers\Auth\RegisterController@ShowCodeForm');

Route::middleware(['auth'])->group(function () {

  Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');

  Route::get('/tasks', 'TasksController@ShowTasksAddForm');
  Route::post('/tasks/add', 'TasksController@addTask')->name('addTask');
  Route::get('/tasks/delete/{task_id}', 'TasksController@DeleteTask')->name('deleteTask');
  Route::get('/tasks/delete/file/{task_id}/{file_id}', 'TasksController@deleteFile')->name('deleteFile');

});
