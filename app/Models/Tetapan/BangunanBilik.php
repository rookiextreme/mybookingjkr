<?php

namespace App\Models\Tetapan;

use App\Http\Controllers\Common\CommonController;
use App\Http\Controllers\Validation\ValidationController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class BangunanBilik extends Model
{
    use HasFactory;

    public function bilikBangunan(){
        return $this->hasOne(Bangunan::class, 'id', 'bangunans_id');
    }

    public static function storeUpdate(Request $request){
        try {
            $v = new ValidationController();
            $v = $v->validateInput([
                $v->input('bilik_name','Nama Bilik', 'mix', $request->input('bilik_name')),
                $v->input('bilik_lokasi','Lokasi', 'int', $request->input('bilik_lokasi')),
                $v->input('bilik_bangunan','Bangunan', 'int', $request->input('bilik_bangunan')),
                $v->input('bilik_aras','Lokasi Bangunan', 'int', $request->input('bilik_aras')),
                $v->input('bilik_kapasiti','Kapasiti', 'int', $request->input('bilik_kapasiti')),
            ]);


            $bilik_id = $request->input('bilik_id');

            $trigger = $request->input('trigger');

            $d = self::checkDuplicate($v->bilik_name, $bilik_id, $v->bilik_bangunan);
            if($d){
                return CommonController::errorResponse('This Record Exist!');
            }

            $model = CommonController::getModel(BangunanBilik::class, $trigger, $bilik_id);

            $model->bangunans_id = $v->bilik_bangunan;
            $model->nama = $v->bilik_name;
            $model->aras = $v->bilik_aras;
            $model->kapasiti = $v->bilik_kapasiti;

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
        $model = BangunanBilik::whereRaw('LOWER(nama) = ? ', [strtolower($name)])->where(function($query) use ($id, $bangunan_id){
            if($id){
                $query->where('id', '!=', $id);
            }
        })->where('bangunans_id', $bangunan_id)->where('delete_id', 0)->first();

        return !($model == null);
    }
}
