<?php
namespace App\Http\Controllers\Segment\Admin\Bilik;

use App\Http\Controllers\Common\CommonController;
use App\Http\Controllers\Controller;
use App\Models\Tetapan\Bangunan;
use App\Models\Tetapan\BangunanBilik;
use App\Models\Tetapan\Lokasi;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class BilikController extends Controller{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $lokasiList = Lokasi::where('flag', 1)->where('delete_id', 0)->get();
        return view('segment.admin.bilik.index', [
            'lokasiList' => $lokasiList
        ]);
    }

    public function getBilikList(){
        $model = BangunanBilik::where('delete_id', 0);

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

        $data = [];
        $data['nama'] = $model->nama;
        $data['lokasi_id'] = $model->bilikBangunan->lokasis_id;
        $data['bangunan_id'] = $model->bangunans_id;
        $data['aras'] = $model->aras;
        $data['kapasiti'] = $model->kapasiti;

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
}
