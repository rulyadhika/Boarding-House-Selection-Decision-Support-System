<?php

namespace Database\Seeders;

use App\Models\CriteriaDistance;
use App\Models\CriteriaFacility;
use App\Models\CriteriaPrice;
use App\Models\CriteriaRoomSize;
use App\Models\Kost;
use App\Models\KostCategory;
use App\Models\KostMatrix;
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
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

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

        CriteriaPrice::insert([
            [
                'nama_kriteria' => '< Rp. 250.000',
                'bobot' => 1,
            ],
            [
                'nama_kriteria' => 'Rp. 250.000 <= x < Rp. 350.000',
                'bobot' => 2,
            ],
            [
                'nama_kriteria' => 'Rp. 350.000 <= x < Rp. 500.000',
                'bobot' => 3,
            ],
            [
                'nama_kriteria' => 'Rp. 500.000 <=  x < Rp. 650.000',
                'bobot' => 4,
            ],
            [
                'nama_kriteria' => '>= Rp. 650.000',
                'bobot' => 5,
            ],
        ]);

        CriteriaDistance::insert([
            [
                'nama_kriteria' => '<= 100 m',
                'bobot' => 1,
            ],
            [
                'nama_kriteria' => '100 m < x <= 250 m',
                'bobot' => 2,
            ],
            [
                'nama_kriteria' => '250 m < x < 500 m',
                'bobot' => 3,
            ],
            [
                'nama_kriteria' => '500 m < x < 1 km',
                'bobot' => 4,
            ],
            [
                'nama_kriteria' => '>= 1 km',
                'bobot' => 5,
            ],
        ]);

        CriteriaRoomSize::insert([
            [
                'nama_kriteria' => '3 x 4 m',
                'bobot' => 1,
            ],
            [
                'nama_kriteria' => '4 x 4 m',
                'bobot' => 2,
            ],
            [
                'nama_kriteria' => '4 x 5 m',
                'bobot' => 3,
            ],
            [
                'nama_kriteria' => '5 x 5 m',
                'bobot' => 4,
            ],
            [
                'nama_kriteria' => '5 x 6 m',
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

        for ($i = 0; $i < 20; $i++) {
            $kost = Kost::factory()->create();

            KostMatrix::create([
                'id_kost' => $kost->id,
                'biaya' => CriteriaPrice::find($kost->kriteria_biaya)->bobot,
                'jarak' => CriteriaDistance::find($kost->kriteria_jarak)->bobot,
                'luas_kamar' => CriteriaRoomSize::find($kost->kriteria_luas_kamar)->bobot,
                'fasilitas' => CriteriaFacility::find($kost->kriteria_fasilitas)->bobot,
            ]);
        }
    }
}
