<?php

namespace App\Models\Mykj;

use Illuminate\Database\Eloquent\Model;

class ListPegawai2 extends Model
{
    protected $connection = 'pgsqlmykj';
    protected $table = 'public.list_pegawai2';
//    public $timestamps = false;

    public static function getMaklumatPegawai(Int $no_ic) : array{
        $data = [];
        $maklumatPegawaiGet = ListPegawai2::where('nokp', $no_ic)->first();

        if($maklumatPegawaiGet) {
            $maklumatPegawai = $maklumatPegawaiGet->toArray();

            $data['nokp'] = $no_ic;
            $data['name'] = $maklumatPegawai['nama'];
            $data['tel_bimbit'] = $maklumatPegawai['tel_bimbit'];
            $data['tel_pejabat'] = $maklumatPegawai['tel_pejabat'];
            $data['alamat_pejabat'] = $maklumatPegawai['alamat_pejabat'];
            $data['gred'] = $maklumatPegawai['kod_gred'];
            $data['email'] = $maklumatPegawai['email'];
            $data['jawatan'] = $maklumatPegawai['jawatan'];
            $data['waran_split'] = ListPegawai2::split_kod_waran($maklumatPegawai['kod_waran']);
            $data['waran_name'] = ListPegawai2::split_kod_waran_name($data['waran_split']);
        }

        return $data;
    }

    public static function split_kod_waran($kod_waran){
        $data = [];
        $data['sektor'] = substr($kod_waran, 0, 2).'0000000000';
        $data['cawangan'] = substr($kod_waran, 0, 4).'00000000';
        $data['bahagian'] = substr($kod_waran, 0, 6).'000000';
        $data['unit'] = substr($kod_waran, 0, 8).'0000';
        $data['waran_penuh'] = $kod_waran;

        return $data;
    }

    public static function split_kod_waran_name($waran_split_arr) : array{
        $data = [];

        foreach ($waran_split_arr as $name => $waran){
            $penempatan_name = LWaranPej::where('kod_waran_pej', $waran)->where('ref_id', 0)->where('flag', 1)->first();
            $data[$name] = $penempatan_name->waran_pej ?? null;
        }

        return $data;
    }

    public static function getWaranName($kod_waran) : String{
        return LWaranPej::where('kod_waran_pej', $kod_waran)->where('ref_id', 0)->where('flag', 1)->first()->waran_pej;
    }

    public static function getMaklumatPegawaiTanpaWaran($no_ic){
        $data = [];
        $maklumatPegawai = ListPegawai2::where('nokp', $no_ic)->first()->toArray();

        $data['nokp'] = $no_ic;
        $data['name'] = $maklumatPegawai['nama'];
        $data['tel_bimbit'] = $maklumatPegawai['tel_bimbit'];
        $data['tel_pejabat'] = $maklumatPegawai['tel_pejabat'];
        $data['alamat_pejabat'] = $maklumatPegawai['alamat_pejabat'];
        $data['gred'] = $maklumatPegawai['kod_gred'];
        $data['email'] = $maklumatPegawai['email'];
        $data['jawatan'] = $maklumatPegawai['jawatan'];

        return $data;
    }
}
