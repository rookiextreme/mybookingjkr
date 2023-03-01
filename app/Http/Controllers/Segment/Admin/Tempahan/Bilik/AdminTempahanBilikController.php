<?php
namespace App\Http\Controllers\Segment\Admin\Tempahan\Bilik;

use App\Http\Controllers\Common\CommonController;
use App\Http\Controllers\Controller;
use App\Jobs\SendEmailLulusTempahan;
use App\Jobs\SendEmailTempahan;
use App\Models\Mykj\ListPegawai2;
use App\Models\Tempahan\TempahanBilik;
use App\Models\Tetapan\BangunanBilik;
use App\Models\Tetapan\Fasiliti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $model = TempahanBilik::where('tempahan_biliks.delete_id', 0);

        if(Auth::user()->id != 1){
            $model->select('*', 'tempahan_biliks.id as temp_id')->join('bangunan_biliks', 'bangunan_biliks.id', '=', 'tempahan_biliks.bangunan_biliks_id')->where('bangunan_biliks.users_id', Auth::user()->id);
        }
        $model->orderBy('tempahan_biliks.created_at', 'desc')->get();



        return DataTables::of($model)
            ->setRowAttr([
                'data-tempahan-id' => function($data) {
//                    echo '<pre>';
//                    print_r($data);
//                    echo '</pre>';
//                    die();
                    return $data->temp_id;
                },
            ])
            ->addColumn('nama', function($data){
                return $data->tempahanBilik->nama.'<br> '.$data->tempahanBilik->kapasiti.' orang<br> Aras '.$data->tempahanBilik->aras.'<br> Bangunan '.$data->tempahanBilik->bilikBangunan->bangunanLokasi->nama.'('.$data->tempahanBilik->bilikBangunan->nama.')' ;
            })
            ->addColumn('maklumat', function($data){
                $getUrusetia = ListPegawai2::getMaklumatPegawai($data->nokp_urusetia);
                return 'Tujuan: '.$data->nama.'<br> Urusetia: '.$getUrusetia['name'].'<br> Pengerusi: '.$data->pengerusi.'<br>Telefon: '.$data->tel_urusetia.'<br>Waktu Tempahan: '.date('d-m-Y H:i', strtotime($data->created_at)) ;
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

//        echo '<pre>';
//        print_r($data);
//        echo '</pre>';
//        die();

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

//        if($status == 1){
//            dispatch(new SendEmailLulusTempahan($model->id));
//        }else{
//            dispatch(new SendEmailLulusTempahan($model->id));
//        }

        return response()->json([
            'success' => 1,
            'data' => $status
        ]);
    }
}
