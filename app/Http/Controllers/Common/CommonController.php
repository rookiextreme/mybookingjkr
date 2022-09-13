<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Models\Mykj\ListPegawai2;
use App\Models\Tetapan\Bangunan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CommonController extends Controller
{
    public static function errorResponse($message){
        return response()->json($message)->setStatusCode(500)->header('Content-Type', 'application/json');
    }

    public static function dateAugment($date, $reverse = false){
        return date($reverse ? 'd-m-Y' : 'Y-m-d', strtotime($date) );
    }

    public static function get_profile(){

        $profile = Auth::user()->userProfile;

        $data['first_name'] = $profile->first_name ?? null;
        $data['last_name'] = $profile->last_name ?? null;
        $data['ic_no'] = $profile->ic_no ?? null;
        $data['genders_id'] = $profile->genders_id ?? null;
        $data['dob'] = isset($profile->dob) ? self::dateAugment($profile->dob, true) : null;
        $data['sob_id'] = $profile->sob_id ?? null;
        $data['cob_id'] = $profile->cob_id ?? null;
        $data['marital_statuses'] = $profile->marital_statuses_id ?? null;

        return response()->json([
            'success' => 1,
            'data' => $data
        ]);
    }

    public static function upload_image($photo, $folder){
        $filename = $photo->getClientOriginalName();
        $extension = $photo->getClientOriginalExtension();
        $image = str_replace(' ', '+', $photo);
        $imagename = Str::random(10).'.'. $extension;
        $photo->move($folder, $imagename);

        return $imagename;
    }

    public static function unlink_image($folder){
        File::delete($folder);
    }

    public static function getModel($class, $trigger, $id = false){

        if($trigger == 0){
            $model = new $class;
            $model->flag = 1;
            $model->delete_id = 0;
            return $model;
        }else{
            return $class::find($id);
        }
    }

    public static function softDeleteRecord($class, $id) : void{
        $getModel = CommonController::getModel($class, 1, $id);
        $getModel->delete_id = 1;
        $getModel->save();
    }

    public static function activateRecord($class, $id) : void{
        $getModel = CommonController::getModel($class, 1, $id);
        $getModel->flag = $getModel->flag == 1 ? 0 : 1;
        $getModel->save();
    }

    public function getBangunan(Request $request){
        $model = Bangunan::where('lokasis_id', $request->input('lokasi_id'))->where('flag', 1)->where('delete_id', 0)->get();
        $data = [];
        if($model){
            foreach($model as $m){
                $data[] = [
                    'label' => $m->nama,
                    'value' => $m->id,
                ];
            }
        }

        return response()->json([
            'success' => 1,
            'data' => $data
        ]);
    }

    public function pengguna_carian(Request $request){

        $data = [];
        $search_term = $request->input('q');
        $peribadi = ListPegawai2::where('nokp', 'ilike', '%'.$search_term.'%')
            ->orWhereRaw("LOWER(nama) ilike '%".$search_term."%'")->limit(10)->get();

        if(count($peribadi) != 0){
            foreach($peribadi as $p){
                $data[] = array(
                    'id' => $p->nokp,
                    'text' => html_entity_decode($p->nama, ENT_QUOTES | ENT_HTML5).' - '.$p->nokp
                );
            }
        }

        return response()->json([
            'data' => $data
        ]);
    }

    public function pengguna_telefon(Request $request){
        $model = ListPegawai2::getMaklumatPegawai($request->input('nokp'));

        return response()->json([
            'data' => str_replace('-', '', $model['tel_bimbit'])
        ]);

    }
}
