<?php
namespace App\Http\Controllers\Segment\Dashboard;

use App\Http\Controllers\Controller;
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
        $model = DB::select(DB::raw("SELECT CONCAT(j.nama, ', ', bb.nama , ', Bangunan ', b.nama, ', ', l.nama) as title,                                  DATE(j.masa_mula) as start, DATE(j.masa_tamat) as end from tempahan_biliks j
                                    join bangunan_biliks bb on j.bangunan_biliks_id = bb.id
                                    join bangunans b on b.id = bb.bangunans_id
                                    join lokasis l on l.id = b.lokasis_id
                                    where j.status = 1
                                "));

        return response()->json($model);
    }
}
