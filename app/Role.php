<?php

namespace App;

use DB;
use Silber\Bouncer\Database\Models;
use Silber\Bouncer\Database\Role as BouncerRole;

class Role extends BouncerRole
{
    public function abilities()
    {
        $db = DB::connection('mysql2')->getDatabaseName();
        return $this->belongsToMany(Models::classname(Ability::class), $db.'.role_abilities');
    }

    public function users()
    {
        $db = DB::connection('mysql2')->getDatabaseName();
        return $this->belongsToMany(Models::classname(User::class), $db.'.user_roles');
    }
}
