<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Prioridades extends Model
{
    use SoftDeletes;

    protected $table = 'prioridades';

    protected $fillable = [
        'descripcion','peso','tiempo_alerta','tiempo_limite','tiempo_escala'
    ];
}
