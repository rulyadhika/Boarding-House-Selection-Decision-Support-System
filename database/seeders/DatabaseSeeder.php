<?php

namespace Database\Seeders;

use App\Models\CriteriaDistance;
use App\Models\CriteriaFacility;
use App\Models\CriteriaPrice;
use App\Models\CriteriaRoomSize;
use App\Models\Kost;
use App\Models\KostCategory;
use App\Models\KostMatrix;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(1)->create([
            'username' => 'admin'
        ]);

        KostCategory::insert([
            [
                'nama_kategori' => 'Laki - laki',
            ],
            [
                'nama_kategori' => 'Perempuan',
            ],
            [
                'nama_kategori' => 'Campur',
            ]
        ]);

        // batas bawah batas atas
        CriteriaPrice::insert([
            [
                'batas_atas' => 250000,
                'batas_bawah' => 0,
                'bobot' => 1,
            ],
            [
                'batas_atas' => 350000,
                'batas_bawah' => 250000,
                'bobot' => 2,
            ],
            [
                'batas_atas' => 500000,
                'batas_bawah' => 350000,
                'bobot' => 3,
            ],
            [
                'batas_atas' => 650000,
                'batas_bawah' => 500000,
                'bobot' => 4,
            ],
            [
                'batas_atas' => 1000000,
                'batas_bawah' => 650000,
                'bobot' => 5,
            ],
        ]);

        CriteriaDistance::insert([
            [
                'batas_atas' => 500,
                'batas_bawah' => 0,
                'bobot' => 1,
            ],
            [
                'batas_atas' => 1000,
                'batas_bawah' => 500,
                'bobot' => 2,
            ],
            [
                'batas_atas' => 3000,
                'batas_bawah' => 1000,
                'bobot' => 3,
            ],
            [
                'batas_atas' => 5000,
                'batas_bawah' => 3000,
                'bobot' => 4,
            ],
            [
                'batas_atas' => 10000,
                'batas_bawah' => 5000,
                'bobot' => 5,
            ],
        ]);

        CriteriaRoomSize::insert([
            [
                'batas_atas' => 9,  //3x3
                'batas_bawah' => 6, //2x3
                'bobot' => 1,
            ],
            [
                'batas_atas' => 12,  //4x3
                'batas_bawah' => 9, //3x3
                'bobot' => 2,
            ],
            [
                'batas_atas' => 16,  //4x4
                'batas_bawah' => 12, //4x3
                'bobot' => 3,
            ],
            [
                'batas_atas' => 20,  //5x4
                'batas_bawah' => 16, //4x4
                'bobot' => 4,
            ],
            [
                'batas_atas' => 50,  //~
                'batas_bawah' => 20, //4x5
                'bobot' => 5,
            ],
        ]);

        CriteriaFacility::insert([
            [
                'nama_kriteria' => 'Kasur',
                'bobot' => 1,
            ],
            [
                'nama_kriteria' => 'Lemari, Kasur, Meja',
                'bobot' => 2,
            ],
            [
                'nama_kriteria' => 'Lemari, Kasur, Kipas angin, Meja',
                'bobot' => 3,
            ],
            [
                'nama_kriteria' => 'Lemari, Kasur, Kipas angin, Meja, Wifi',
                'bobot' => 4,
            ],
            [
                'nama_kriteria' => 'Kamar mandi dalam, Lemari, Kasur, Kipas angin, Meja, Wifi',
                'bobot' => 5,
            ],
        ]);


        for ($i = 0; $i < 10; $i++) {
            $kost = Kost::factory()->create();

            KostMatrix::create([
                'id_kost' => $kost->id,
                'biaya' => CriteriaPrice::where('batas_bawah', '<', $kost->biaya)->where('batas_atas', '>=', $kost->biaya)->first()->bobot,
                'jarak' => CriteriaDistance::where('batas_bawah', '<', $kost->jarak)->where('batas_atas', '>=', $kost->jarak)->first()->bobot,
                'luas_kamar' => CriteriaRoomSize::where('batas_bawah', '<', $kost->luas_kamar)->where('batas_atas', '>=', $kost->luas_kamar)->first()->bobot,
                'fasilitas' => CriteriaFacility::find($kost->kriteria_fasilitas)->bobot,
            ]);
        }
    }
}
