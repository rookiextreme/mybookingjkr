<?php

namespace App\Models\Tempahan;

use App\Http\Controllers\Common\CommonController;
use App\Http\Controllers\Validation\ValidationController;
use App\Jobs\SendEmailTempahan;
use App\Models\Tetapan\BangunanBilik;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TempahanBilik extends Model
{
    use HasFactory;

    public function tempahanBilik(){
        return $this->hasOne(BangunanBilik::class, 'id', 'bangunan_biliks_id');
    }

    public function tempahanUser(){
        return $this->hasOne(User::class, 'id', 'users_id');
    }

    public static function storeUpdate(Request $request){
        try {
            $v = new ValidationController();

            $v = $v->validateInput([
                $v->input('tempahan_bilik_bilik','Bilik', 'int', $request->input('tempahan_bilik_bilik')),
                $v->input('tempahan_bilik_name','Nama bilik', 'mix', $request->input('tempahan_bilik_name')),
                $v->input('tempahan_bilik_urusetia','Urusetia', 'mix', $request->input('tempahan_bilik_urusetia')),
                $v->input('tempahan_bilik_notel_urusetia','No. Telefon Urusetia', 'int', $request->input('tempahan_bilik_notel_urusetia')),
                $v->input('tempahan_bilik_pengerusi','Pengerusi', 'mix', $request->input('tempahan_bilik_pengerusi')),
                $v->input('tempahan_bilik_agensi','Agensi Dalam', 'int', $request->input('tempahan_bilik_agensi')),
                $v->input('tempahan_bilik_agensi_l','Agensi L', 'int', $request->input('tempahan_bilik_agensi_l')),
                $v->input('tempahan_masa_mula','Tarikh Mula', 'datetime', $request->input('tempahan_masa_mula')),
                $v->input('tempahan_masa_tamat','Tarikh Tamat', 'datetime', $request->input('tempahan_masa_tamat')),
            ]);

            $tempahan_bilik_id = $request->input('tempahan_bilik_id');

            $trigger = $request->input('trigger');

            $getBilikKap = CommonController::getModel(BangunanBilik::class, 1, $v->tempahan_bilik_bilik)->kapasiti;
            $totalKap = $v->tempahan_bilik_agensi + $v->tempahan_bilik_agensi_l;

            if($totalKap > $getBilikKap ){
                return response()->json([
                    'success' => 2
                ]);
            }

            $model = CommonController::getModel(TempahanBilik::class, $trigger, $tempahan_bilik_id);

            $model->users_id = Auth::user()->id;
            $model->bangunan_biliks_id = $v->tempahan_bilik_bilik;
            $model->nama = $v->tempahan_bilik_name;
            $model->masa_mula = date('Y-m-d H:i', strtotime($v->tempahan_masa_mula));
            $model->masa_tamat = date('Y-m-d H:i', strtotime($v->tempahan_masa_tamat));
            $model->nokp_urusetia = $v->tempahan_bilik_urusetia;
            $model->tel_urusetia = $v->tempahan_bilik_notel_urusetia;
            $model->pengerusi = $v->tempahan_bilik_pengerusi;
            $model->bil_agensi_d = $v->tempahan_bilik_agensi;
            $model->bil_agensi_l = $v->tempahan_bilik_agensi_l;
            $model->nota = $request->input('tempahan_bilik_nota');
            $model->status = 0;

//            dispatch(SendEmailTempahan::class($model->id));
            if($model->save()){
                return response()->json([
                    'success' => 1
                ]);
            }
        }catch (Exception $e){
            return CommonController::errorResponse($e->getMessage());
        }
    }

    public static function checkDuplicate($name, $id = false, $bangunan_id = false){
        $model = TempahanBilik::whereRaw('LOWER(nama) = ? ', [strtolower($name)])->where(function($query) use ($id, $bangunan_id){
            if($id){
                $query->where('id', '!=', $id);
            }
        })->where('bangunans_id', $bangunan_id)->where('delete_id', 0)->first();

        return !($model == null);
    }
}
