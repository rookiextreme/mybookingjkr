<?php

namespace App\Models;

use App\Models\Penilaian\Main\Penilaian;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Laratrust\Traits\LaratrustUserTrait;

use App\Models\Profiles\Profile;
use App\Models\Profiles\ProfilesAlamatPejabat;
use App\Models\Profiles\ProfilesCawanganLog;
use App\Models\Profiles\ProfilesTelefon;
use App\Models\LaratrustModels\RoleUser;
use App\Models\Regular\AgencyPenyelaras;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function user_profile(){
        return $this->hasOne('App\Models\Profiles\Profile', 'users_id', 'id')
            ->where('flag',1)
            ->where('delete_id',0)
            ->orderBy('id', 'desc')->limit(1);
    }

    public function users_roles(){
        return $this->hasOne('App\Models\LaratrustModels\RoleUser', 'user_id', 'id');
    }

    public static function createOrUpdate($peg_maklumat){
        $user = User::where('nokp', $peg_maklumat['nokp'])->first();
        if(!$user) {
            $user = new User;
            $user->nokp = $peg_maklumat['nokp'];
            $user->name = $peg_maklumat['name'];
            $user->email = $peg_maklumat['email'];
            $user->password = Hash::make('123123123');
        }else {
            $user->email = $peg_maklumat['email'];
        }

        if($user->save()){
            $profile = User::profileCheckAndCreate($user->id);

            if($profile){
                $cawangan = User::penempatanCheckAndCreate($peg_maklumat, $profile->id);
                if($cawangan){
                    $profileTelefon = User::telefonCheckAndCreate($peg_maklumat, $profile->id);
                    if($profileTelefon){
                        User::alamatCheckAndCreate($peg_maklumat, $profile->id);
                    }
                }
            }
            $role_user = User::rolePenggunaCheckAndCreate($user->id);

            if($role_user){
                return 1;
            }
        }
    }

    public static function profileCheckAndCreate($users_id){
        $check = Profile::where('users_id', $users_id)->where('flag', 1)->where('delete_id', 0)->orderBy('id', 'desc')->first();

        if(!$check){
            $profile = new Profile();
        }else{
            return $check;
        }

        $profile->users_id = $users_id;
        $profile->flag = 1;
        $profile->delete_id = 0;
        $profile->save();

        return $profile;
    }

    public static function penempatanCheckAndCreate($peg_maklumat, $profile_id){
        $check = ProfilesCawanganLog::where('profiles_id', $profile_id)->where('flag', 1)->where('delete_id', 0)->orderBy('id', 'desc')->first();

        if(!$check){
            $cawanganLogs = new ProfilesCawanganLog();
        }else{
            if($check->penempatan == $peg_maklumat['waran_split']['waran_penuh']){
                return $check;
            }else{
                $cawanganLogs = new ProfilesCawanganLog();
            }
        }

        $cawanganLogs->profiles_id = $profile_id;
        $cawanganLogs->sektor = $peg_maklumat['waran_split']['sektor'];
        $cawanganLogs->cawangan = $peg_maklumat['waran_split']['cawangan'];
        $cawanganLogs->bahagian = $peg_maklumat['waran_split']['bahagian'];
        $cawanganLogs->unit = $peg_maklumat['waran_split']['unit'];
        $cawanganLogs->penempatan = $peg_maklumat['waran_split']['waran_penuh'];
        $cawanganLogs->sektor_name = $peg_maklumat['waran_name']['sektor'];
        $cawanganLogs->cawangan_name = $peg_maklumat['waran_name']['cawangan'];
        $cawanganLogs->bahagian_name = $peg_maklumat['waran_name']['bahagian'];
        $cawanganLogs->unit_name = $peg_maklumat['waran_name']['unit'];
        $cawanganLogs->penempatan_name = $peg_maklumat['waran_name']['waran_penuh'];
        $cawanganLogs->tahun = date('Y');
        $cawanganLogs->gred = $peg_maklumat['gred'];
        $cawanganLogs->flag = 1;
        $cawanganLogs->delete_id = 0;
        $cawanganLogs->save();

        return $cawanganLogs;
    }

    public static function telefonCheckAndCreate($peg_maklumat, $profile_id){
        $check = ProfilesTelefon::where('profiles_id', $profile_id)->where('flag', 1)->where('delete_id', 0)->orderBy('id', 'desc')->first();

        if(!$check){
            $profileTelefon = new ProfilesTelefon();
        }else{
            if($check->no_tel_bimbit == $peg_maklumat['tel_bimbit'] && $check->no_tel_pejabat == $peg_maklumat['tel_pejabat']){
                return $check;
            }else{
                $profileTelefon = new ProfilesTelefon();
            }
        }

        $profileTelefon->profiles_id = $profile_id;
        $profileTelefon->no_tel_bimbit = $peg_maklumat['tel_bimbit'];
        $profileTelefon->no_tel_pejabat = $peg_maklumat['tel_pejabat'];
        $profileTelefon->flag = 1;
        $profileTelefon->delete_id = 0;
        $profileTelefon->save();

        return $profileTelefon;
    }

    public static function alamatCheckAndCreate($peg_maklumat, $profile_id){
        $check = ProfilesAlamatPejabat::where('profiles_id', $profile_id)->where('flag', 1)->where('delete_id', 0)->orderBy('id', 'desc')->first();

        if(!$check){
            $alamat = new ProfilesAlamatPejabat();
        }else{
            if($check->alamat == $peg_maklumat['alamat_pejabat']){
                return $check;
            }else{
                $alamat = new ProfilesAlamatPejabat();
            }
        }

        $alamat->profiles_id = $profile_id;
        $alamat->alamat = $peg_maklumat['alamat_pejabat'];
        $alamat->flag = 1;
        $alamat->delete_id = 0;
        $alamat->save();

        return $alamat;
    }

    public static function rolePenggunaCheckAndCreate($users_id){
        $check = RoleUser::where('user_id', $users_id)->where('role_id', 2)->first();

        if(!$check){
            $role_user = new RoleUser;
        }else{
            return $check;
        }
        $role_user->user_id = $users_id;
        $role_user->role_id = 2;
        $role_user->user_type = 'App\Models\User';
        $role_user->save();

        return $role_user;
    }

    public static function getPengguna($profile_id){
        $profile = Profile::find($profile_id);
        $profile_user = $profile->profile_Users;

        $data = [
            'user_info' => [
                'user_id' => $profile_user->id,
                'name' => $profile_user->name,
                'nric' => $profile_user->nokp,
                'penempatan' => $profile->profile_Profile_cawangan_log_active->penempatan_name ?? '',
                'gred' => $profile->profile_Profile_cawangan_log_active->gred ?? '',
                'telefon' => [
                    'pejabat' => $profile->profile_Profile_telefon->no_tel_pejabat ?? '',
                    'bimbit' => $profile->profile_Profile_telefon->no_tel_bimbit ?? '',
                ]
            ],
            'roles' => User::getPenggunaRoles($profile_user->id)
        ];

        return $data;
    }

    public static function getPenggunaRoles($profile_id) : array{
        $data = [];
        $model = RoleUser::where('user_id', $profile_id)->get();

        if(count($model) > 0){
            foreach ($model as $roles){
                $data[] = [
                    'id' => $roles->roleUserRole->id,
                    'name' => $roles->roleUserRole->name,
                ];
            }
        }
        return $data;
    }

    public static function roleUpdate($data){
        $roleArr = json_decode($data['roleArr']);
        $user_id = $data['user_id'];

        RoleUser::where('user_id', $user_id)->delete();

        foreach($roleArr as $r){
            $newQuery = new RoleUser;
            $newQuery->user_id = $user_id;
            $newQuery->role_id = $r;
            $newQuery->user_type = 'App\Models\User';
            $newQuery->save();
        }

        return 1;
    }
}
