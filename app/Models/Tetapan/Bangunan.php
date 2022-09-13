<?php

namespace App\Models\Tetapan;

use App\Http\Controllers\Common\CommonController;
use App\Http\Controllers\Validation\ValidationController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Bangunan extends Model
{
    use HasFactory;

    public function bangunanLokasi(){
        return $this->hasOne(Lokasi::class, 'id', 'lokasis_id');
    }

    public static function storeUpdate(Request $request){
        try {
            $v = new ValidationController();
            $v = $v->validateInput([
                $v->input('bangunan_name','Nama Bangunan', 'mix', $request->input('bangunan_name')),
                $v->input('bangunan_lokasi','Lokasi Bangunan', 'int', $request->input('bangunan_lokasi')),
            ]);


            $bangunan_id = $request->input('bangunan_id');

            $trigger = $request->input('trigger');

            $d = self::checkDuplicate($v->bangunan_name, $bangunan_id, $v->bangunan_lokasi);
            if($d){
                return CommonController::errorResponse('This Record Exist!');
            }

            $model = CommonController::getModel(Bangunan::class, $trigger, $bangunan_id);

            $model->lokasis_id = $v->bangunan_lokasi;
            $model->nama = $v->bangunan_name;

            if($model->save()){
                return response()->json([
                    'success' => 1
                ]);
            }
        }catch (Exception $e){
            return CommonController::errorResponse($e->getMessage());
        }
    }

    public static function checkDuplicate($name, $id = false, $lokasi_id = false){
        $model = Bangunan::whereRaw('LOWER(nama) = ? ', [strtolower($name)])->where(function($query) use ($id, $lokasi_id){
            if($id){
                $query->where('id', '!=', $id);
            }
        })->where('lokasis_id', $lokasi_id)->where('delete_id', 0)->first();

        return !($model == null);
    }
}
