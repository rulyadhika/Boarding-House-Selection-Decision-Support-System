<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kost extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function matrix(){
        return $this->hasOne(KostMatrix::class,'id_kost');
    }

    public function category(){
        return $this->belongsTo(KostCategory::class,'id_kategori');
    }

    public function price(){
        return $this->belongsTo(CriteriaPrice::class,'kriteria_biaya');
    }

    public function distance(){
        return $this->belongsTo(CriteriaDistance::class,'kriteria_jarak');
    }

    public function roomSize(){
        return $this->belongsTo(CriteriaRoomSize::class,'kriteria_luas_kamar');
    }

    public function facility(){
        return $this->belongsTo(CriteriaFacility::class,'kriteria_fasilitas');
    }
}
