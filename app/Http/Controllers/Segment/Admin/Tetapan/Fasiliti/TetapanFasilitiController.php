<?php
namespace App\Http\Controllers\Segment\Admin\Tetapan\Fasiliti;

use App\Http\Controllers\Common\CommonController;
use App\Http\Controllers\Controller;
use App\Models\Tetapan\Fasiliti;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class TetapanFasilitiController extends Controller{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        return view('segment.admin.tetapan.fasiliti.index');
    }

    public function getFasilitiList(){
        $model = Fasiliti::where('delete_id', 0);

        return DataTables::of($model)
            ->setRowAttr([
                'data-fasiliti-id' => function($data) {
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

    public function fasilitiStoreUpdate(Request $request){
        return Fasiliti::storeUpdate($request);
    }

    public function getFasiliti(Request $request){
        $id = $request->input('id');
        $model = Fasiliti::find($id);

        $data = [];
        $data['nama'] = $model->nama;

        return response()->json([
            'success' => 1,
            'data' => $data
        ]);
    }

    public function activateFasiliti(Request $request){
        CommonController::activateRecord(Fasiliti::class, $request->input('id'));

        return response()->json([
            'success' => 1,
            'data' => [],
        ]);
    }

    public function deleteFasiliti(Request $request){
        CommonController::softDeleteRecord(Fasiliti::class, $request->input('id'));
        return response()->json([
            'success' => 1,
        ]);
    }
}
