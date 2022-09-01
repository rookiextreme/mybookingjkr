<?php
namespace App\Models\Profiles;

use Illuminate\Database\Eloquent\Model;

class ProfilesTelefon extends Model
{
    public function profile_telefon_Profile(){
        return $this->hasOne('App\Models\Profiles\Profile', 'id', 'profiles_id');
    }
}
