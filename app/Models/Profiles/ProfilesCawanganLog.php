<?php
namespace App\Models\Profiles;

use Illuminate\Database\Eloquent\Model;

class ProfilesCawanganLog extends Model
{
    public function profile_cawangan_log_Profile(){
        return $this->hasOne('App\Models\Profiles\Profile', 'id', 'profiles_id');
    }
}
