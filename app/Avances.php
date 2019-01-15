<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Avances extends Model
{
  use SoftDeletes;

  protected $table = 'seg_actividades';
  
}
