<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActividadesSp extends Model
{
    use SoftDeletes;

    protected $table = 'sp_actividad';

    public function tiempo()
    {
        return $this->hasOne('App\ParamReferenciales', 'id', 'id_refertiempo');
    }

}
