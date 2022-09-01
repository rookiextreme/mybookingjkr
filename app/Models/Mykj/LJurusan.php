<?php

namespace App\Models\Mykj;

use Illuminate\Database\Eloquent\Model;

class LJurusan extends Model
{
    protected $connection = 'pgsqlmykj';
    protected $table = 'public.l_jurusan';
    // protected $primaryKey = 'kod_jurusan';

//    public $timestamps = false;
}
