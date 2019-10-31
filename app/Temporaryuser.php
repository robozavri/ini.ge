<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Temporaryuser extends Model
{
      protected $table = 'temporaryusers';

      protected $fillable = [
          'name','surename', 'email', 'pasport_id','code'
      ];

}
