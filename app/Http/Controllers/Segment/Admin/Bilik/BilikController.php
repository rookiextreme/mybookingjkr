<?php
namespace App\Http\Controllers\Segment\Admin\Bilik;

use App\Http\Controllers\Common\CommonController;
use App\Http\Controllers\Controller;
use App\Models\Tetapan\Bangunan;
use App\Models\Tetapan\BangunanBilik;
use App\Models\Tetapan\BilikFasiliti;
use App\Models\Tetapan\Fasiliti;
use App\Models\Tetapan\Lokasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class BilikController extends Controller{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $lokasiList = Lokasi::where('flag', 1)->where('delete_id', 0)->get();
        $kemudahanList = Fasiliti::where('flag', 1)->where('delete_id', 0)->get();
        return view('segment.admin.bilik.index', [
            'lokasiList' => $lokasiList,
            'kemudahanList' => $kemudahanList
        ]);
    }

    public function getBilikList(){
        $model = BangunanBilik::where('delete_id', 0);

        if(Auth::user()->id != 1){
            $model->where('users_id', Auth::user()->id);
        }

        return DataTables::of($model)
            ->setRowAttr([
                'data-bilik-id' => function($data) {
                    return $data->id;
                },
            ])
            ->addColumn('nama', function($data){
                return $data->nama;
            })->addColumn('lokasi_bangunan_aras', function($data){
                return $data->bilikBangunan->nama.' / Aras '.$data->aras.' / Bangunan '.$data->bilikBangunan->bangunanLokasi->nama;
            })
            ->addColumn('action', function($data){
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function bilikStoreUpdate(Request $request){
        return BangunanBilik::storeUpdate($request);
    }

    public function getBilik(Request $request){
        $id = $request->input('id');
        $model = BangunanBilik::find($id);

        $data = [
            'fasiliti' => []
        ];

        $data['nama'] = $model->nama;
        $data['lokasi_id'] = $model->bilikBangunan->lokasis_id;
        $data['bangunan_id'] = $model->bangunans_id;
        $data['aras'] = $model->aras;
        $data['kapasiti'] = $model->kapasiti;

        $fasiliti = $model->bilikFasiliti;

        if($fasiliti){
            foreach($fasiliti as $f){
                $data['fasiliti'][] = [
                    'id' => $f->id,
                    'fasiliti_name' => $f->BFFasiliti->nama,
                    'fasilitisId' => $f->fasilitis_id,
                    'kuantiti' => $f->kuantiti
                ];
            }
        }

        return response()->json([
            'success' => 1,
            'data' => $data
        ]);
    }

    public function activateBilik(Request $request){
        CommonController::activateRecord(BangunanBilik::class, $request->input('id'));

        return response()->json([
            'success' => 1,
            'data' => [],
        ]);
    }

    public function deleteBilik(Request $request){
        CommonController::softDeleteRecord(BangunanBilik::class, $request->input('id'));
        return response()->json([
            'success' => 1,
        ]);
    }

    public function deleteItemBilik(Request $request){
        $id = $request->input('id');
        $model = BilikFasiliti::find($id);
        $model->delete_id = 1;
        $model->save();

        return response()->json([
            'success' => 1,
        ]);
    }
}
