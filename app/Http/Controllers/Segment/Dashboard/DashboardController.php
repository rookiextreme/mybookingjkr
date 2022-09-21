<?php
namespace App\Http\Controllers\Segment\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Mykj\ListPegawai2;
use App\Models\Tempahan\TempahanBilik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        return view('segment.dashboard.index');
    }

    public function getEvents(Request $request){
        $model = DB::select(DB::raw("SELECT DATE(j.masa_mula) as start, DATE(j.masa_tamat) as end, '#ff9f89' as color, 'background' as display, false as overlap from tempahan_biliks j
                                    join bangunan_biliks bb on j.bangunan_biliks_id = bb.id
                                    join bangunans b on b.id = bb.bangunans_id
                                    join lokasis l on l.id = b.lokasis_id
                                    where j.status = 1
                                "));

        return response()->json($model);
    }

    public function getDateRoom(Request $request){
        $date = $request->input('date');

        $data = [];
        $data['tarikh'] = date("d-m-Y", strtotime($date));
        $model = TempahanBilik::whereDate('masa_mula', $date)->orWhereDate('masa_tamat', $date)->get();

        if($model){
            foreach($model as $m){
                $data['bilik'][] = [
                    'bilik' => $m->tempahanBilik->nama,
                    'mesyuarat' => $m->nama,
                    'urusetia' => ListPegawai2::getMaklumatPegawai($m->nokp_urusetia)['name'],
                    'pengerusi' => $m->pengerusi
                ];
            }
        }

        return response()->json([
            'success' => 1,
            'data' => $data
        ]);
    }
}
