<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ParamReferenciales extends Model
{
  use SoftDeletes;

  protected $table = 'param_referenciales';

  protected $fillable = [
      'grupo','clave','valor','descripcion'
  ];
}
