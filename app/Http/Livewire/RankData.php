<?php

namespace App\Http\Livewire;

use App\Models\Kost;
use App\Models\KostCategory;
use App\Models\KostMatrix;
use Livewire\Component;

class RankData extends Component
{
    public $kostMatrix;
    public $categories;

    public $normalizationMatrix;
    public $rankedData = [];
    public $criteriaWeight;

    public $selectedCategory;
    public $priceCriteriaWeight;
    public $distanceCriteriaWeight;
    public $roomSizeCriteriaWeight;
    public $facilityCriteriaWeight;

    public function mount()
    {
        $this->categories = KostCategory::all();
    }

    public function render()
    {
        return view('livewire.rank-data');
    }

    public function calculate()
    {
        $this->criteriaWeight = collect([
            'biaya' => $this->priceCriteriaWeight, 
            'jarak' => $this->distanceCriteriaWeight, 
            'luas_kamar' => $this->roomSizeCriteriaWeight, 
            'fasilitas' => $this->facilityCriteriaWeight
        ]);

        // cost = biaya, jarak
        $this->kostMatrix = KostMatrix::with(['kost.category', 'kost.price', 'kost.distance', 'kost.facility', 'kost.roomSize'])
            ->whereHas('kost.category', function ($query) {
                $query->where('id', $this->selectedCategory);
            })->get();

        $this->normalize();
    }

    private function normalize()
    {
        $normalizationMatrix = collect();

        $minBiaya = $this->kostMatrix->min('biaya');
        $minJarak = $this->kostMatrix->min('jarak');
        $maxLuasKamar = $this->kostMatrix->max('luas_kamar');
        $maxFasilitas = $this->kostMatrix->max('fasilitas');

        foreach ($this->kostMatrix as $value) {
            $normalizationMatrix->push([
                'biaya' => $minBiaya / $value->biaya,
                'jarak' => $minJarak / $value->jarak,
                'luas_kamar' => $value->luas_kamar / $maxLuasKamar,
                'fasilitas' => $value->fasilitas / $maxFasilitas
            ]);
        }

        $this->normalizationMatrix = $normalizationMatrix;

        $this->rankData();
    }

    private function rankData()
    {
        $rankedData = collect();

        foreach ($this->kostMatrix as $index => $value) {
            $normalizationMatrix = $this->normalizationMatrix[$index];

            $calculatedValue = $normalizationMatrix['biaya'] * $this->criteriaWeight['biaya'] +
                $normalizationMatrix['jarak'] * $this->criteriaWeight['jarak'] +
                $normalizationMatrix['luas_kamar'] * $this->criteriaWeight['luas_kamar'] +
                $normalizationMatrix['fasilitas'] * $this->criteriaWeight['fasilitas'];

            $rankedData->push(collect($value)->put('nilai_perhitungan', $calculatedValue));
        }

        $this->rankedData = $rankedData;
    }
}
