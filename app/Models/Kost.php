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

    public function facility(){
        return $this->belongsTo(CriteriaFacility::class,'kriteria_fasilitas');
    }
}
