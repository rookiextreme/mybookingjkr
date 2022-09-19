<?php
namespace App\Http\Controllers\Segment\Admin\Tempahan\Bilik;

use App\Http\Controllers\Common\CommonController;
use App\Http\Controllers\Controller;
use App\Models\Mykj\ListPegawai2;
use App\Models\Tempahan\TempahanBilik;
use App\Models\Tetapan\BangunanBilik;
use App\Models\Tetapan\Fasiliti;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AdminTempahanBilikController extends Controller{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        return view('segment.admin.tempahan.bilik.index');
    }

    public function getTempahanBilikList(){
        $model = TempahanBilik::where('delete_id', 0);

        return DataTables::of($model)
            ->setRowAttr([
                'data-tempahan-id' => function($data) {
                    return $data->id;
                },
            ])
            ->addColumn('nama', function($data){
                return $data->tempahanBilik->nama.'<br> '.$data->tempahanBilik->kapasiti.' orang<br> Aras '.$data->tempahanBilik->aras.'<br> Bangunan '.$data->tempahanBilik->bilikBangunan->bangunanLokasi->nama.'('.$data->tempahanBilik->bilikBangunan->nama.')' ;
            })
            ->addColumn('maklumat', function($data){
                $getUrusetia = ListPegawai2::getMaklumatPegawai($data->nokp_urusetia);
                return 'Tujuan: '.$data->nama.'<br> Urusetia: '.$getUrusetia['name'].'<br> Pengerusi: '.$data->pengerusi;
            })
            ->addColumn('tempoh', function($data){
                return 'Dari: '.date('d-m-Y H:i', strtotime($data->masa_mula)).' <br> Hingga: '.date('d-m-Y H:i', strtotime($data->masa_tamat));
            })
            ->addColumn('status_tempahan', function($data){
                $label = '';
                if($data->status == 0){
                    $label = '<span style="color:blue">Belum Lulus</span>';
                }else if($data->status == 1){
                    $label = '<span style="color:green">Lulus</span>';
                }
                else if($data->status == 2){
                    $label = '<span style="color:red">Tidak Lulus</span>';
                }
                return $label;
            })
            ->addColumn('action', function($data){
            })
            ->rawColumns(['action', 'nama', 'maklumat', 'tempoh', 'status_tempahan'])
            ->make(true);
    }

    public function getFasilitiBilik(BangunanBilik $bilik){
        $data = [];

        $getFasiliti = $bilik->bilikFasiliti;

        if(count($getFasiliti) > 0){
            foreach($getFasiliti as $gF){
                $data[] = [
                    'nama' => $gF->BFFasiliti->nama,
                    'kuantiti' => $gF->kuantiti
                ];
            }
        }
        return $data;

    }

    public function getTempahanBilik(Request $request){
        $id = $request->input('id');
        $model = TempahanBilik::find($id);

        $data = [];
        $data['tempahan'] = [
            'tempahan' => date('d-m-Y H:i', strtotime($model->created_at)),
            'masa_mula' => date('d-m-Y H:i', strtotime($model->masa_mula)),
            'masa_tamat' => date('d-m-Y H:i', strtotime($model->masa_tamat)),
            'bilik' => $model->tempahanBilik->nama,
            'fasiliti' => self::getFasilitiBilik($model->tempahanBilik)
        ];

        $getUrusetia = ListPegawai2::getMaklumatPegawai($model->nokp_urusetia);
        $data['maklumat'] = [
            'nama' => $model->nama,
            'urusetia' => $getUrusetia['name'],
            'pengerusi' => $model->pengerusi,
            'bil_agensi_d' => $model->bil_agensi_d,
            'bil_agensi_l' => $model->bil_agensi_l,
            'nota' => $model->nota
        ];

        return response()->json([
            'success' => 1,
            'data' => $data
        ]);
    }

    public function lulusTempahanBilik(Request $request){
        $status = $request->input('status');
        $id = $request->input('id');

        $model = CommonController::getModel(TempahanBilik::class, 1, $id);
        $model->status = $status;
        $model->save();

        return response()->json([
            'success' => 1,
            'data' => $status
        ]);
    }
}
