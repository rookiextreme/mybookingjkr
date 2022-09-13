<?php

namespace App\Models\Tetapan;

use App\Http\Controllers\Common\CommonController;
use App\Http\Controllers\Validation\ValidationController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Fasiliti extends Model
{
    use HasFactory;

    public static function storeUpdate(Request $request){
        try {
            $v = new ValidationController();
            $v = $v->validateInput([
                $v->input('fasiliti_name','Nama Fasiliti', 'mix', $request->input('fasiliti_name')),
            ]);

            $fasiliti_id = $request->input('fasiliti_id');

            $trigger = $request->input('trigger');

            $d = self::checkDuplicate($v->fasiliti_name, $fasiliti_id);
            if($d){
                return CommonController::errorResponse('This Record Exist!');
            }

            $model = CommonController::getModel(Fasiliti::class, $trigger, $fasiliti_id);

            $model->nama = $v->fasiliti_name;

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
        $model = Fasiliti::whereRaw('LOWER(nama) = ? ', [strtolower($name)])->where(function($query) use ($id){
            if($id){
                $query->where('id', '!=', $id);
            }
        })->where('delete_id', 0)->first();

        return !($model == null);
    }
}
