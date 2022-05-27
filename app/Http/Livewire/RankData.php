<?php

namespace App\Http\Livewire;

use App\Models\CriteriaDistance;
use App\Models\CriteriaPrice;
use App\Models\CriteriaRoomSize;
use App\Models\Kost;
use App\Models\KostCategory;
use App\Models\KostMatrix;
use Livewire\Component;

class RankData extends Component
{
    public $kostMatrix;
    public $categories;
    public $priceCriteriaRange;
    public $distanceCriteriaRange;
    public $roomSizeCriteriaRange;

    public $normalizationMatrix;
    public $rankedData = [];

    public $selectedPriceCriteria;
    public $selectedDistanceCriteria;
    public $selectedRoomSizeCriteria;

    public $selectedCategory;
    public $priceCriteriaWeight;
    public $distanceCriteriaWeight;
    public $roomSizeCriteriaWeight;
    public $facilityCriteriaWeight;

    public function mount()
    {
        $this->categories = KostCategory::all();
        $this->priceCriteriaRange = CriteriaPrice::all();
        $this->distanceCriteriaRange = CriteriaDistance::all();
        $this->roomSizeCriteriaRange = CriteriaRoomSize::all();
    }

    public function render()
    {
        return view('livewire.rank-data');
    }

    public function calculate()
    {
        $biaya = $this->priceCriteriaRange->find($this->selectedPriceCriteria);
        $jarak = $this->distanceCriteriaRange->find($this->selectedDistanceCriteria);
        $luas_kamar = $this->roomSizeCriteriaRange->find($this->selectedRoomSizeCriteria);

        // cost = biaya, jarak
        $this->kostMatrix = KostMatrix::with(['kost.category', 'kost.facility'])
            ->whereHas('kost.category', function ($query) {
                $query->where('id', $this->selectedCategory);
            })
            ->whereHas('kost', function ($query) use ($biaya, $jarak, $luas_kamar) {
                $query->whereBetween('biaya', [$biaya->batas_bawah, $biaya->batas_atas])
                    ->whereBetween('luas_kamar', [$luas_kamar->batas_bawah, $luas_kamar->batas_atas])
                    ->whereBetween('jarak', [$jarak->batas_bawah, $jarak->batas_atas]);
            })
            ->get();

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

            $calculatedValue = $normalizationMatrix['biaya'] * $this->priceCriteriaWeight +
                $normalizationMatrix['jarak'] * $this->distanceCriteriaWeight +
                $normalizationMatrix['luas_kamar'] * $this->roomSizeCriteriaWeight +
                $normalizationMatrix['fasilitas'] * $this->facilityCriteriaWeight;

            $rankedData->push(collect($value)->put('nilai_perhitungan', $calculatedValue));
        }

        $this->rankedData = $rankedData;
    }
}
