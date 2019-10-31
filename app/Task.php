<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Auth;
use Carbon\Carbon;

class Task extends Model
{

      protected $table = 'tasks';

      protected $fillable = [
          'user_id','title','date'
      ];

      public function GetDateAttributes($value){
         return \Carbon\Carbon::parse($value)->format('d-m-Y');
      }

      public function saveTask(Request $request)
      {

          return $this->create([
            'user_id' => Auth::id(),
            'title' => strip_tags($request->title),
            'date' => \Carbon\Carbon::parse($request->date)->format('Y-m-d'),
          ]);

      }


      public function files()
      {
          return $this->belongsToMany('\App\File','tasks_files','task_id','file_id');
      }




}
