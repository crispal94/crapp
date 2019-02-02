<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RolesTipo extends Model
{
  use SoftDeletes;

  protected $table = 'roles_tipo';

	protected $softDelete = true;

  protected $fillable = [
      'nombre','id_roles'
  ];

  public function tipo()
  {
      return $this->hasOne('App\Roles','id', 'id_roles');
  }

}
