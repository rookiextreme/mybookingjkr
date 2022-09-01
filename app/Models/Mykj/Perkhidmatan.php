<?php
namespace App\Models\Mykj;

use Illuminate\Database\Eloquent\Model;

class Perkhidmatan extends Model{
    protected $connection = 'pgsqlmykj';
    protected $table = 'public.perkhidmatan';

    public static function getStandardGred($nokp){
        $model = self::where('nokp', $nokp)->where('flag', 1)->first();
        //H = Hakiki, M Memangku
        if($model->status_perkhidmatan == 'H'){
            return $model->kod_gred;
        }else{
            $model = self::where('nokp', $nokp)->where('status_perkhidmatan', 'H')->orderBy('kod_gred', 'desc')->first();
            return $model->kod_gred;
        }
    }

    public static function getActualGred($nokp){
        $model = self::where('nokp', $nokp)->where('flag', 1)->first();
        return $model->kod_gred;
    }
}
