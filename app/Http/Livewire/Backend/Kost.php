<?php

namespace App\Http\Livewire\Backend;

use App\Models\Kost as ModelsKost;
use Livewire\Component;
use Livewire\WithFileUploads;

class Kost extends Component
{
    use WithFileUploads;

    public $title;
    public $dataKost = [];
    public $thumbnail = 'default.jpg';

    // for store or update data
    public $namaKost;
    public $alamatKost;
    public $biayaKost;
    public $jarakKost;
    public $luasKamarKost;
    public $statusData;
    public $fotoKost;
    // public $fasilitas;

    protected $listeners = [
        'getKostData',
        'resetKostInput'
    ];

    protected $rules = [
        'namaKost' => 'required',
        'alamatKost' => 'required',
        'biayaKost' => 'required',
        'jarakKost' => 'required',
        'luasKamarKost' => 'required',
        'statusData' => 'required|in:ditampilkan,diarsipkan',
        'fotoKost' => 'required|image|max:1024'
    ];

    public function mount()
    {
        $this->title = 'Kelola Kost';

        $this->dataKost = ModelsKost::with('category')->orderBy('created_at', 'DESC')->get();
    }

    public function render()
    {
        return view('livewire.backend.kost')->layout('layouts.backend');
    }

    public function getKostData($kostId)
    {
        $kostData = ModelsKost::find($kostId);

        if ($kostData == null) {
            return $this->emit('failedAction', ['message' => 'Data kost tidak ditemukan. Silahkan refresh halaman dan coba lagi', 'refresh' => true]);
        }

        $this->fill([
            'namaKost' => $kostData->nama_kost,
            'alamatKost' => $kostData->alamat_kost,
            'biayaKost' => $kostData->biaya,
            'jarakKost' => $kostData->jarak,
            'luasKamarKost' => $kostData->luas_kamar,
            'thumbnail' => $kostData->thumbnail,
            'statusData' => $kostData->status
        ]);
    }

    public function addKostData()
    {
        $validatedData = $this->validate();

        // ModelsKost::create([
        //     'nama_kost' => $validatedData['namaKost'],
        //     'alamat_kost' => $validatedData['alamatKost'],
        //     'biaya' => $validatedData['biayaKost'],
        //     'jarak' => $validatedData['jarakKost'],
        //     'luas_kamar' => $validatedData['luasKamarKost'],
        //     'thumbnail' => $validatedData['thumbnail'],
        //     'status' => $validatedData['statusData']
        // ]);

        $this->dataKost = ModelsKost::with('category')->orderBy('created_at', 'DESC')->get();

        $this->resetKostInput();

        $this->emit('dataKostModified', ['message' => 'Data kost berhasil ditambahkan']);
    }

    public function resetKostInput()
    {
        $this->reset(['namaKost', 'alamatKost', 'biayaKost', 'jarakKost', 'luasKamarKost', 'fotoKost', 'statusData', 'thumbnail']);
    }
}
