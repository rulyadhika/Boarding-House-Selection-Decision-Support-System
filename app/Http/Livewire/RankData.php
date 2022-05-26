<?php

namespace App\Http\Livewire;

use Livewire\Component;

class RankData extends Component
{
    public $matrixDataKost = [];
    public $normalizationMatrix = [];
    public $rankedData = [];
    public $criteriaWeight = [];

    public function mount()
    {   
        $this->criteriaWeight = collect(['biaya' => 30, 'jarak' => 20, 'luas_kamar' => 10, 'fasilitas' => 40]);
        // cost = biaya, jarak
        $this->matrixDataKost = collect([
            [
                'nama' => 'kost 1',
                'biaya' => 1,
                'jarak' => 2,
                'luas_kamar' => 1,
                'fasilitas' => 5
            ],
            [
                'nama' => 'kost 2',
                'biaya' => 1,
                'jarak' => 2,
                'luas_kamar' => 1,
                'fasilitas' => 1
            ],
            [
                'nama' => 'kost 3',
                'biaya' => 1,
                'jarak' => 1,
                'luas_kamar' => 1,
                'fasilitas' => 1
            ],
            [
                'nama' => 'kost 4',
                'biaya' => 1,
                'jarak' => 1,
                'luas_kamar' => 1,
                'fasilitas' => 3
            ],
        ]);

        $this->normalize();
        $this->rankData();
    }

    public function render()
    {
        return view('livewire.rank-data');
    }

    private function normalize(){
        $normalizationMatrix = collect();

        $minBiaya = $this->matrixDataKost->min('biaya');
        $minJarak = $this->matrixDataKost->min('jarak');
        $maxLuasKamar = $this->matrixDataKost->max('luas_kamar');
        $maxFasilitas = $this->matrixDataKost->max('fasilitas');

        foreach ($this->matrixDataKost as $value) {
            $normalizationMatrix->push([
                'biaya' => $minBiaya/$value['biaya'],
                'jarak' => $minJarak/$value['jarak'],
                'luas_kamar' => $value['luas_kamar']/$maxLuasKamar,
                'fasilitas' => $value['fasilitas']/$maxFasilitas
            ]);
        }
        // foreach ($this->matrixDataKost as $value) {
        //     $normalizationMatrix->push([
        //         'biaya'=> $minBiaya/$value->biaya,
        //         'jarak'=> $minJarak/$value->jarak,
        //         'luas_kamar'=> $value->luas_kamar/$maxLuasKamar,
        //         'fasilitas'=> $value->fasilitas/$maxFasilitas
        //     ]);
        // }

        $this->normalizationMatrix = $normalizationMatrix;
    }

    private function rankData(){
        $rankedData = collect();

        foreach ($this->matrixDataKost as $index => $value) {
            $normalizationMatrix = $this->normalizationMatrix[$index];

            $calculatedValue = $normalizationMatrix['biaya'] * $this->criteriaWeight['biaya'] + 
                     $normalizationMatrix['jarak'] * $this->criteriaWeight['jarak'] +
                     $normalizationMatrix['luas_kamar'] * $this->criteriaWeight['luas_kamar'] +
                     $normalizationMatrix['fasilitas'] * $this->criteriaWeight['fasilitas'];

            $rankedData->push(collect($value)->put('nilai_perhitungan',$calculatedValue));
        }

        dd($rankedData->sortByDesc('nilai_perhitungan'));
    }
}
