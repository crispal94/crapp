<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
  use SoftDeletes;

	protected $softDelete = true;

  protected $fillable = [
      'nombre','id_param'
  ];

  public function users()
{
    return $this
          ->belongsToMany('App\User')
          ->withTimestamps();
}

public function tipo()
{
    return $this->hasOne('App\ParamReferenciales','id', 'id_param');
}
}
