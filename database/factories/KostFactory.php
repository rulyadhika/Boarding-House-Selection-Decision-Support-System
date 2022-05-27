<?php

namespace Database\Factories;

use App\Models\CriteriaFacility;
use App\Models\KostCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

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
            'biaya'=> $this->faker->numberBetween(100000, 1000000),
            'jarak'=> $this->faker->numberBetween(10, 5000),
            'luas_kamar'=> $this->faker->numberBetween(3, 5) * $this->faker->numberBetween(3, 5),
            'kriteria_fasilitas' => CriteriaFacility::inRandomOrder()->first(),
            'thumbnail' => Arr::random(['1.jpg','2.jpg','3.jpg','4.jpg','5.jpg'])
        ];
    }
}
