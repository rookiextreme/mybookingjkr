<?php
namespace App\Http\Controllers\Segment\Pengguna\Tempahan;

use App\Http\Controllers\Common\CommonController;
use App\Http\Controllers\Controller;
use App\Models\Tempahan\TempahanBilik;
use App\Models\Tetapan\BangunanBilik;
use App\Models\Tetapan\Lokasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use App\Models\Mykj\ListPegawai2;

class TempahanBilikController extends Controller{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $bangunanBilikList = BangunanBilik::where('flag', 1)->where('delete_id', 0)->get();
        return view('segment.pengguna.tempahan.bilik.index', [
            'bangunanBilik' => $bangunanBilikList
        ]);
    }

    public function getTempahanBilikList(){
        $model = TempahanBilik::where('delete_id', 0)->where('users_id', Auth::user()->id);

        return DataTables::of($model)
            ->setRowAttr([
                'data-tempahan-bilik-id' => function($data) {
                    return $data->id;
                },
            ])
            ->addColumn('bilik', function($data){
                return $data->tempahanBilik->nama;
            })->addColumn('maklumat', function($data){
                return $data->tempahanBilik->bilikBangunan->nama;
            })
            ->addColumn('tempoh', function($data){
                return 'Dari: '.date('d-m-Y H:i', strtotime($data->masa_mula)).' <br> Hingga: '.date('d-m-Y H:i', strtotime($data->masa_tamat));
            })->addColumn('status_label', function($data){
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
            ->rawColumns(['action', 'tempoh', 'status_label'])
            ->make(true);
    }

    public function tempahanBilikStoreUpdate(Request $request){
        return TempahanBilik::storeUpdate($request);
    }

    public function getTempahanBilik(Request $request){
        $id = $request->input('id');
        $model = TempahanBilik::find($id);

        $data = [];
        $data['nama'] = $model->nama;
        $data['lokasi_id'] = $model->tempahanBilik->bilikBangunan->lokasis_id;
        $data['bangunan_id'] = $model->bangunans_id;
        $data['aras'] = $model->aras;
        $data['kapasiti'] = $model->kapasiti;

        return response()->json([
            'success' => 1,
            'data' => $data
        ]);
    }

    public function deleteTempahanBilik(Request $request){
        CommonController::softDeleteRecord(TempahanBilik::class, $request->input('id'));
        return response()->json([
            'success' => 1,
        ]);
    }

    public function tengokKosongTempahanBilik(Request $request){
        $avail = 0;
        $masa_mula = $request->input('tempahan_bilik_masa_mula');
        $masa_tamat = $request->input('tempahan_bilik_masa_tamat');
        $tempahan_bilik_bilik = $request->input('tempahan_bilik_bilik');

        $mula_date_reformat = date('Y-m-d H:i:s', strtotime($masa_mula));
        $tamat_time_reformat = date('Y-m-d H:i:s', strtotime($masa_tamat));

        $checkTempahan = TempahanBilik::where('masa_mula', '>=', $mula_date_reformat)->where('masa_tamat', '<=', $tamat_time_reformat)->where('delete_id', 0)->where('bangunan_biliks_id', $tempahan_bilik_bilik)->first();

        if($checkTempahan){
            $avail = 1;
        }

        return response()->json([
            'success' => 1,
            'data' => $avail
        ]);
    }

    public function getViewTempahanBilik(Request $request){
        $id = $request->input('id');
        $model = TempahanBilik::find($id);

        $status = '';
        if ($model->status==0){
            $status = 'Belum Lulus';
        } elseif ($model->status==1){
            $status = 'Lulus';
        } else{
            $status = 'Tidak Lulus';
        }

        $data = [];
        $data['tempahan'] = [
            'status_tempahan' => $status,
            'no_ruj' => $id,
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
}
