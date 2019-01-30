<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Actividades extends Model
{
  use SoftDeletes;

  protected $table = 'det_actividad';

  public function tiempo()
  {
      return $this->hasOne('App\ParamReferenciales','id', 'id_refertiempo');
  }
}
