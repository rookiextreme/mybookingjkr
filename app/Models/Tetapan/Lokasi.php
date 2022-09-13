<?php

namespace App\Models\Tetapan;

use App\Http\Controllers\Common\CommonController;
use App\Http\Controllers\Validation\ValidationController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Lokasi extends Model
{
    use HasFactory;

    public static function storeUpdate(Request $request){
        try {
            $v = new ValidationController();
            $v = $v->validateInput([
                $v->input('lokasi_name','Nama Lokasi', 'mix', $request->input('lokasi_name')),
            ]);

            $lokasi_id = $request->input('lokasi_id');

            $trigger = $request->input('trigger');

            $d = self::checkDuplicate($v->lokasi_name, $lokasi_id);
            if($d){
                return CommonController::errorResponse('This Record Exist!');
            }

            $model = CommonController::getModel(Lokasi::class, $trigger, $lokasi_id);

            $model->nama = $v->lokasi_name;

            if($model->save()){
                return response()->json([
                    'success' => 1
                ]);
            }
        }catch (Exception $e){
            return CommonController::errorResponse($e->getMessage());
        }
    }

    public static function checkDuplicate($name, $id = false){
        $model = Lokasi::whereRaw('LOWER(nama) = ? ', [strtolower($name)])->where(function($query) use ($id){
            if($id){
                $query->where('id', '!=', $id);
            }
        })->where('delete_id', 0)->first();

        return !($model == null);
    }
}
