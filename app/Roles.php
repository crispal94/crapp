<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Roles extends Model
{
  use SoftDeletes;

	protected $softDelete = true;

  protected $fillable = [
      'nombre'
  ];

  public function users()
{
    return $this
          ->belongsToMany('App\User')
          ->withTimestamps();
}
}
