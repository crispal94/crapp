<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proyectos extends Model
{
  use SoftDeletes;

  protected $table = 'cab_actividad';

  protected $fillable = [
      'id_responsable','duracion','id_userogroup','nombre','descripcion','fechainicio','fechafin'
  ];

  public function responsable()
  {
      return $this->hasOne('App\User','id', 'id_responsable');
  }

}
