<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KostMatrix extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function kost()
    {
        return $this->belongsTo(Kost::class, 'id_kost');
    }

    public function scopeFilter($query, $filter)
    {
        $query->when($filter['category'], function ($query, $key) {
            $query->whereHas('kost.category', function ($query) use ($key) {
                $query->where('id', $key);
            });
        });

        $query->when($filter['biaya'], function ($query, $key) {
            $query->whereHas('kost', function ($query) use ($key) {
                $query->whereBetween('biaya', [$key->batas_bawah, $key->batas_atas]);
            });
        });

        $query->when($filter['luas_kamar'], function ($query, $key) {
            $query->whereHas('kost', function ($query) use ($key) {
                $query->whereBetween('luas_kamar', [$key->batas_bawah, $key->batas_atas]);
            });
        });

        $query->when($filter['jarak'], function ($query, $key) {
            $query->whereHas('kost', function ($query) use ($key) {
                $query->whereBetween('jarak', [$key->batas_bawah, $key->batas_atas]);
            });
        });

        return $query;
    }
}
