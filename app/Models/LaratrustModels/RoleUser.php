<?php

namespace App\Models\LaratrustModels;

use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
    public $timestamps = false;
    protected $table = 'role_user';

    public function roleUserRole(){
        return $this->hasOne('App\Models\LaratrustModels\Role', 'id', 'role_id');
    }
}
