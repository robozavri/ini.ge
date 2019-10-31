<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\File;
use App\Task;
use Auth;

class TasksController extends Controller
{
    public function ShowTasksAddForm()
    {
      $tasks = Task::all();
      return view('ShowTasksAddForm',[
        'tasks' => $tasks,
      ]);
    }

    public function addTask(Request $request)
    {

       $this->validator($request->all())->validate();
       $Task = new Task;
       $created_task = $Task->saveTask($request);

       if($request->hasfile('files'))
       {
          foreach($request->file('files') as $file)
          {
              $name = $file->getClientOriginalName();
              $ext = $file->getClientOriginalExtension();
              $newname = md5(microtime().$name).'.'.$ext;
              $path = public_path('/uploads/');
              $file->move($path,$newname);

              $upload = File::create([
                'name' => $newname,
                'original_name' => $name.$ext,
                'path' => $path,
              ]);

              $created_task->files()->attach( $upload->id );
              $data[] = $newname;
          }
       }

        return redirect('/tasks');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'title' => ['required', 'string' ,'max:255'],
            'date' => ['required','date_format:d-m-Y'],
        ]);
    }

    public function DeleteTask($task_id)
    {
          if (!filter_var($task_id, FILTER_VALIDATE_INT))
          {
             return back();
          }

          $user = Auth::user();
          $task =  $user->TasksById($task_id);
          $files = $task->files;

          foreach($files as $file)
          {
              unlink(public_path('/uploads/'.$file->name));
          }

          $task->files()->detach();
          $task->delete();
          File::destroy($files->pluck('id'));
          return back();
    }

    public function deleteFile($task_id,$file_id)
    {
          if (!filter_var($task_id, FILTER_VALIDATE_INT) || !filter_var($file_id, FILTER_VALIDATE_INT))
          {
             return back();
          }

          $user = Auth::user();
          $task =  $user->TasksById($task_id);
          $task->files()->detach($file_id);
          $file = File::find($file_id);
          unlink(public_path('/uploads/'.$file->name));
          $file->delete();

          return back();
    }
}
