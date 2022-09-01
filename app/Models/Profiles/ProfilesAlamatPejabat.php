<?php
namespace App\Models\Profiles;

use Illuminate\Database\Eloquent\Model;

class ProfilesAlamatPejabat extends Model
{
    public function profile_alamat_pejabat_Profile(){
        return $this->hasOne('App\Models\Profiles\Profile', 'id', 'profiles_id');
    }
}
