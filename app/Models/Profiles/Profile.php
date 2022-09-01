<?php
namespace App\Models\Profiles;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    public function profile_Users(){
        return $this->hasOne('App\Models\User', 'id', 'users_id');
    }

    public function profile_Profile_cawangan_log(){
        return $this->hasMany('App\Models\Profiles\ProfilesCawanganLog', 'profiles_id', 'id');
    }

    public function profile_Profile_cawangan_log_active(){
        return $this->hasOne('App\Models\Profiles\ProfilesCawanganLog', 'profiles_id', 'id')->orderBy('id', 'desc');
    }

    public function profile_Profile_telefon(){
        return $this->hasOne('App\Models\Profiles\ProfilesTelefon', 'profiles_id', 'id')->orderBy('id', 'desc');
    }

    public function profile_Profile_alamat_pejabat(){
        return $this->hasMany('App\Models\Profiles\ProfilesAlamatPejabat', 'profiles_id', 'id');
    }

    public function profileDictBankSet(){
        return $this->hasMany('App\Models\Penilaian\DictBank\Set\DictColSet', 'profiles_id', 'id');
    }

    public function profileDictBankJobgroupSet(){
        return $this->hasMany('App\Models\Penilaian\Jobgroup\Set\DictColJobgroupSet', 'profiles_id', 'id');
    }

    public function profilePenyeliaPenilaian(){
        return $this->hasMany('App\Models\Penilaian\Main\Penilaian', 'id', 'penyelia_profiles_id');
    }
}
