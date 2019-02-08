<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proyectos extends Model
{
  use SoftDeletes;

  protected $table = 'cab_actividad';

  protected $fillable = [
      'id_responsable','duracion','id_userogroup','nombre','descripcion','fechainicio','fechafin','id_refertiempo'
  ];

  public function responsable()
  {
      return $this->hasOne('App\User','id', 'id_responsable');
  }

  public function tiempo()
  {
      return $this->hasOne('App\ParamReferenciales','id', 'id_refertiempo');
  }

  public function actividades()
    {
        return $this->hasMany('App\Actividades','id_cabecera','id');
    }

    public function actividadesTrashed()
      {
          return $this->hasMany('App\Actividades','id_cabecera','id')->withTrashed();
      }

}
