<?php

namespace App\Models\Tetapan;

use App\Http\Controllers\Common\CommonController;
use App\Http\Controllers\Validation\ValidationController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BangunanBilik extends Model
{
    use HasFactory;

    public function bilikBangunan(){
        return $this->hasOne(Bangunan::class, 'id', 'bangunans_id');
    }

    public function bilikFasiliti(){
        return $this->hasMany(BilikFasiliti::class, 'biliks_id', 'id')->where('flag', 1)->where('delete_id', 0);
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

            $model->users_id = Auth::user()->id;
            $model->bangunans_id = $v->bilik_bangunan;
            $model->nama = $v->bilik_name;
            $model->aras = $v->bilik_aras;
            $model->kapasiti = $v->bilik_kapasiti;

            if($model->save()){
                $kemudahan_list = json_decode($request->input('kemudahan_list'));
                if(!empty($kemudahan_list)){
                    BangunanBilik::addFasiliti($kemudahan_list, $model->id);
                }

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

    public static function addFasiliti($kemudahan, $bilik_id){
        foreach($kemudahan as $k){
            $model = BilikFasiliti::where('biliks_id', $bilik_id)->where('fasilitis_id', $k[0])->first();

            if(!$model){
                $model = new BilikFasiliti;
                $model->biliks_id = $bilik_id;
                $model->flag = 1;
                $model->delete_id = 0;
            }

            $model->kuantiti = $k[1];
            $model->fasilitis_id = $k[0];
            $model->save();
        }
    }
}
