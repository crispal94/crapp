<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;



class RolUser extends Model
{
    	use SoftDeletes;

      protected $table = 'role_user';
}
