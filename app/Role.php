<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
  use SoftDeletes;

	protected $softDelete = true;

  protected $fillable = [
      'nombre','tipo'
  ];

  public function users()
{
    return $this
          ->belongsToMany('App\User')
          ->withTimestamps();
}
}
