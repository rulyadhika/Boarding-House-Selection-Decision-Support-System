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
        $ownerGender = Arr::random(["male", "female"]);

        return [
            'id_kategori' => KostCategory::inRandomOrder()->first(),
            'nama_kost' => "Kost " . ($ownerGender == "male" ? "Pak " . $this->faker->firstNameMale() : "Bu " . $this->faker->firstNameFemale()),
            'alamat_kost' => $this->faker->address(),
            'biaya' => $this->faker->numberBetween(100000, 1000000),
            'jarak' => $this->faker->numberBetween(10, 5000),
            'luas_kamar' => $this->faker->numberBetween(3, 5) * $this->faker->numberBetween(3, 5),
            'kriteria_fasilitas' => CriteriaFacility::inRandomOrder()->first(),
            'thumbnail' => Arr::random(['1.webp', '2.webp', '3.webp', '4.webp', '5.webp', '6.webp', '7.webp', '8.webp', '9.webp', '10.webp'])
        ];
    }
}
