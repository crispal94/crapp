<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoActividades extends Model
{
  use SoftDeletes;

  protected $table = 'tipo_actividades';

  protected $fillable = [
      'descripcion','id_referencia'
  ];

  public function referencia()
  {
      return $this->hasOne('App\ParamReferenciales','id', 'id_referencia');
  }

}
