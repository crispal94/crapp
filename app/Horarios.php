<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Horarios extends Model
{
    use SoftDeletes;

    protected $table = 'actividades_horario';

}
