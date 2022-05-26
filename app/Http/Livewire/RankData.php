<?php

namespace App\Http\Livewire;

use App\Models\Kost;
use App\Models\KostMatrix;
use Livewire\Component;

class RankData extends Component
{
    public $kostMatrix;

    public $normalizationMatrix;
    public $rankedData;
    public $criteriaWeight;

    public function mount()
    {
        $this->criteriaWeight = collect(['biaya' => 30, 'jarak' => 20, 'luas_kamar' => 10, 'fasilitas' => 40]);
        // cost = biaya, jarak
        $this->kostMatrix = KostMatrix::with('kost.category')->whereHas('kost.category', function ($query) {
            $query->where('nama_kategori', 'Campur');
        })->get();

        $this->normalize();
    }

    public function render()
    {
        dd($this->rankedData);
        return view('livewire.rank-data');
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

        $this->rankedData = $rankedData->sortByDesc('nilai_perhitungan');
    }
}
