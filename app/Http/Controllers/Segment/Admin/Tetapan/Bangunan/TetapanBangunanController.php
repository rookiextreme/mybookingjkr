<?php
namespace App\Http\Controllers\Segment\Admin\Tetapan\Bangunan;

use App\Http\Controllers\Common\CommonController;
use App\Http\Controllers\Controller;
use App\Models\Tetapan\Bangunan;
use App\Models\Tetapan\Lokasi;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class TetapanBangunanController extends Controller{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $lokasiList = Lokasi::where('delete_id', 0)->where('flag', 1)->get();
        return view('segment.admin.tetapan.bangunan.index', [
            'lokasiList' => $lokasiList
        ]);
    }

    public function getBangunanList(){
        $model = Bangunan::where('delete_id', 0);

        return DataTables::of($model)
            ->setRowAttr([
                'data-bangunan-id' => function($data) {
                    return $data->id;
                },
            ])
            ->addColumn('nama', function($data){
                return $data->nama;
            })->addColumn('lokasi', function($data){
                return $data->bangunanLokasi->nama;
            })
            ->addColumn('action', function($data){
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function bangunanStoreUpdate(Request $request){
        return Bangunan::storeUpdate($request);
    }

    public function getBangunan(Request $request){
        $id = $request->input('id');
        $model = Bangunan::find($id);

        $data = [];
        $data['nama'] = $model->nama;
        $data['lokasi_id'] = $model->lokasis_id;

        return response()->json([
            'success' => 1,
            'data' => $data
        ]);
    }

    public function activateBangunan(Request $request){
        CommonController::activateRecord(Bangunan::class, $request->input('id'));

        return response()->json([
            'success' => 1,
            'data' => [],
        ]);
    }

    public function deleteBangunan(Request $request){
        CommonController::softDeleteRecord(Bangunan::class, $request->input('id'));
        return response()->json([
            'success' => 1,
        ]);
    }
}
