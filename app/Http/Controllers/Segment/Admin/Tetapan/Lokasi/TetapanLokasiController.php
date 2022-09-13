<?php
namespace App\Http\Controllers\Segment\Admin\Tetapan\Lokasi;

use App\Http\Controllers\Common\CommonController;
use App\Http\Controllers\Controller;
use App\Models\Tetapan\Lokasi;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class TetapanLokasiController extends Controller{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        return view('segment.admin.tetapan.lokasi.index');
    }

    public function getLokasiList(){
        $model = Lokasi::where('delete_id', 0);

        return DataTables::of($model)
            ->setRowAttr([
                'data-lokasi-id' => function($data) {
                    return $data->id;
                },
            ])
            ->addColumn('nama', function($data){
                return $data->nama;
            })
            ->addColumn('action', function($data){
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function lokasiStoreUpdate(Request $request){
        return Lokasi::storeUpdate($request);
    }

    public function getLokasi(Request $request){
        $id = $request->input('id');
        $model = Lokasi::find($id);

        $data = [];
        $data['nama'] = $model->nama;

        return response()->json([
            'success' => 1,
            'data' => $data
        ]);
    }

    public function activateLokasi(Request $request){
        CommonController::activateRecord(Lokasi::class, $request->input('id'));

        return response()->json([
            'success' => 1,
            'data' => [],
        ]);
    }

    public function deleteLokasi(Request $request){
        CommonController::softDeleteRecord(Lokasi::class, $request->input('id'));
        return response()->json([
            'success' => 1,
        ]);
    }
}
