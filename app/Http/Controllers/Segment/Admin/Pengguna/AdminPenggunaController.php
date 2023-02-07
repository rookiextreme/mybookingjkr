<?php

namespace App\Http\Controllers\Segment\Admin\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\LaratrustModels\RoleUser;
use App\Models\Profiles\Profile;
use App\Models\Tetapan\Fasiliti;
use app\models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AdminPenggunaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        return view('segment.admin.pengguna.index');
    }

    public function getList(){
        $model = Profile::all()->where('delete_id', 0);

        return DataTables::of($model)
            ->setRowAttr([
                'data-id' => function($data) {
                    return $data->profile_Users->id;
                },
            ])
            ->addColumn('nama', function($data){
                return $data->profile_Users->name;
            })
            ->addColumn('peranan', function($data){
                $roles = $data->profile_Users->users_roles_all;
                $str = '';
                if($roles){
                    foreach($roles as $r){
                        $name = $r->roleUserRole;
                        $str .= '- '.$name->display_name.'<br>';
                    }
                }

                return $str;
            })
            ->addColumn('action', function($data){
            })
            ->rawColumns(['action', 'peranan'])
            ->make(true);
    }

    public function getPengguna(Request $request){
        $id = $request->input('id');
        $model = RoleUser::where('user_id', $id)->get();

        $data = [];

        if($model){
            foreach($model as $m){
                $data['roles'][] = $m->role_id;
            }
        }

//        echo '<pre>';
//        print_r($data);
//        echo '</pre>';
//        die();
        return response()->json([
            'success' => 1,
            'data' => $data
        ]);
    }

    public function storeUpdate(Request $request){
        $peranan = json_decode($request->input('peranan'));
        $user_id = $request->input('user_id');

        RoleUser::where('user_id', $user_id)->delete();
        foreach($peranan as $p){
            $m = new RoleUser;
            $m->user_id = $user_id;
            $m->role_id = $p;
            $m->user_type = 'App\Models\User';
            $m->save();
        }

        return response()->json([
            'success' => 1,
            'data' => []
        ]);
    }
}
