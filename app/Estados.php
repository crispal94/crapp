<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Estados extends Model
{
  use SoftDeletes;

  protected $table = 'estado';

  protected $fillable = [
      'descripcion','color'
  ];
}
