<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Historia extends Model
{
  use SoftDeletes;

  protected $table = 'historia_actividad';
}
