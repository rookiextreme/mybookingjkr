<?php

namespace App\Models\Tetapan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BilikFasiliti extends Model
{
    use HasFactory;

    public function BFBilik(){
        return $this->hasOne(BangunanBilik::class, 'biliks_id', 'id');
    }

    public function BFFasiliti(){
        return $this->hasOne(Fasiliti::class, 'id', 'fasilitis_id');
    }
}
