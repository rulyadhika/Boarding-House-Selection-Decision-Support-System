<?php

namespace Database\Factories;

use App\Models\CriteriaDistance;
use App\Models\CriteriaFacility;
use App\Models\CriteriaPrice;
use App\Models\CriteriaRoomSize;
use App\Models\KostCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Kost>
 */
class KostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'id_kategori' => KostCategory::inRandomOrder()->first(),
            'nama_kost' => $this->faker->words(2, true),
            'alamat_kost' => $this->faker->address(),
            'kriteria_biaya' => CriteriaPrice::inRandomOrder()->first(),
            'kriteria_jarak' => CriteriaDistance::inRandomOrder()->first(),
            'kriteria_luas_kamar' => CriteriaRoomSize::inRandomOrder()->first(),
            'kriteria_fasilitas' => CriteriaFacility::inRandomOrder()->first(),
        ];
    }
}
