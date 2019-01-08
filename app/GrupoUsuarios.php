<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GrupoUsuarios extends Model
{
  use SoftDeletes;

  protected $table = 'grupos_trabajos';

  protected $fillable = [
      'descripcion','nickname','usuarios'
  ];
}
