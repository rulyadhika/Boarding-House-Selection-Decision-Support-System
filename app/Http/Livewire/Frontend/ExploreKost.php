<?php

namespace App\Http\Livewire\Frontend;

use App\Models\CriteriaDistance;
use App\Models\CriteriaPrice;
use App\Models\CriteriaRoomSize;
use App\Models\KostCategory;
use App\Models\KostMatrix;
use Livewire\Component;

class ExploreKost extends Component
{
    public $title = "Cari Kost";

    public $kostMatrix;
    public $categories;
    public $priceCriteriaRange;
    public $distanceCriteriaRange;
    public $roomSizeCriteriaRange;

    public $normalizationMatrix;
    protected $rankedData = [];

    public $selectedPriceCriteria;
    public $selectedDistanceCriteria;
    public $selectedRoomSizeCriteria;

    public $selectedCategory;
    public $priceCriteriaWeight = 25;
    public $distanceCriteriaWeight = 25;
    public $roomSizeCriteriaWeight = 25;
    public $facilityCriteriaWeight = 25;
    public $page;

    protected $queryString = [
        'page' => ['except' => 1],
        'selectedPriceCriteria' => ['except' => '', 'as' => 'price'],
        'selectedDistanceCriteria' => ['except' => '', 'as' => 'distance'],
        'selectedRoomSizeCriteria' => ['except' => '', 'as' => 'size'],
        'selectedCategory' => ['except' => '', 'as' => 'category']
    ];

    public function updated()
    {
        $this->reset('page');
    }

    public function mount()
    {
        $this->categories = KostCategory::all();
        $this->priceCriteriaRange = CriteriaPrice::all();
        $this->distanceCriteriaRange = CriteriaDistance::all();
        $this->roomSizeCriteriaRange = CriteriaRoomSize::all();

        $biaya = $this->priceCriteriaRange->find($this->selectedPriceCriteria);
        $jarak = $this->distanceCriteriaRange->find($this->selectedDistanceCriteria);
        $luas_kamar = $this->roomSizeCriteriaRange->find($this->selectedRoomSizeCriteria);

        $this->kostMatrix = KostMatrix::with(['kost.category', 'kost.facility'])
            ->filter([
                'category' => $this->selectedCategory,
                'biaya' => $biaya,
                'jarak' => $jarak,
                'luas_kamar' => $luas_kamar
            ])->whereHas('kost', function ($query) {
                $query->where('status', 'ditampilkan');
            })->get();

        $this->normalize();
    }

    public function render()
    {
        $data = [
            'rankedData' => $this->rankedData
        ];

        return view('livewire.frontend.explore-kost', $data);
    }

    public function calculate()
    {
        $totalPersentaseBobot = $this->priceCriteriaWeight + $this->distanceCriteriaWeight + $this->roomSizeCriteriaWeight + $this->facilityCriteriaWeight;

        if ($totalPersentaseBobot > 100) {
            return $this->addError('persentaseBobot', 'Total persentase bobot tidak boleh melebihi 100%');
        }

        $biaya = $this->priceCriteriaRange->find($this->selectedPriceCriteria);
        $jarak = $this->distanceCriteriaRange->find($this->selectedDistanceCriteria);
        $luas_kamar = $this->roomSizeCriteriaRange->find($this->selectedRoomSizeCriteria);

        // cost = biaya, jarak
        $this->kostMatrix = KostMatrix::with(['kost.category', 'kost.facility'])
            ->filter([
                'category' => $this->selectedCategory,
                'biaya' => $biaya,
                'jarak' => $jarak,
                'luas_kamar' => $luas_kamar
            ])->whereHas('kost', function ($query) {
                $query->where('status', 'ditampilkan');
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

            $calculatedValue = $normalizationMatrix['biaya'] * $this->priceCriteriaWeight +
                $normalizationMatrix['jarak'] * $this->distanceCriteriaWeight +
                $normalizationMatrix['luas_kamar'] * $this->roomSizeCriteriaWeight +
                $normalizationMatrix['fasilitas'] * $this->facilityCriteriaWeight;

            $rankedData->push(collect($value)->put('nilai_perhitungan', round($calculatedValue, 2)));
        }

        $this->rankedData = $rankedData->paginate(5);
    }
}
