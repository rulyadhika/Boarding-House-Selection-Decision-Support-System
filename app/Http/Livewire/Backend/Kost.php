<?php

namespace App\Http\Livewire\Backend;

use App\Models\CriteriaDistance;
use App\Models\CriteriaPrice;
use App\Models\CriteriaRoomSize;
use App\Models\Kost as ModelsKost;
use App\Models\KostCategory;
use App\Models\KostMatrix;
use Livewire\Component;
use Livewire\WithFileUploads;

class Kost extends Component
{
    use WithFileUploads;

    public $title;
    public $dataKost = [];
    public $kostCategories = [];
    public $thumbnail = 'default.jpg';

    // for store or update data
    public $kategoriKost;
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
        'kategoriKost' => 'required|exists:kost_categories,id',
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
        $this->kostCategories = KostCategory::all();
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

        $biaya = optional(CriteriaPrice::where('batas_bawah', '<', $this->biayaKost)->where('batas_atas', '>=', $this->biayaKost)->first())->bobot;
        $jarak = optional(CriteriaDistance::where('batas_bawah', '<', $this->jarakKost)->where('batas_atas', '>=', $this->jarakKost)->first())->bobot;
        $luas_kamar = optional(CriteriaRoomSize::where('batas_bawah', '<', $this->luasKamarKost)->where('batas_atas', '>=', $this->luasKamarKost)->first())->bobot;

        if ($biaya == null) {
            return $this->addError('biayaKost', 'Biaya ini tidak masuk dalam bobot kriteria apapun. Silahkan cek kembali!');
        }

        if ($jarak == null) {
            return $this->addError('jarakKost', 'Jarak ini tidak masuk dalam bobot kriteria apapun. Silahkan cek kembali!');
        }

        if ($luas_kamar == null) {
            return $this->addError('luasKamarKost', 'Luas kamar ini tidak masuk dalam bobot kriteria apapun. Silahkan cek kembali!');
        }

        $photoName = uniqid() . '.' .  $this->fotoKost->extension();

        // move image to temp file
        $this->fotoKost->storeAs('src/images/kost', $photoName, 'public');

        $kost = ModelsKost::create([
            'id_kategori' => 1,
            'nama_kost' => $validatedData['namaKost'],
            'alamat_kost' => $validatedData['alamatKost'],
            'biaya' => $validatedData['biayaKost'],
            'jarak' => $validatedData['jarakKost'],
            'luas_kamar' => $validatedData['luasKamarKost'],
            'kriteria_fasilitas' => 3,
            'thumbnail' => $photoName,
            'status' => $validatedData['statusData']
        ]);

        KostMatrix::create([
            'id_kost' => $kost->id,
            'biaya' => $biaya,
            'jarak' => $jarak,
            'luas_kamar' => $luas_kamar,
            'fasilitas' => 3,
        ]);

        $this->dataKost = ModelsKost::with('category')->orderBy('created_at', 'DESC')->get();

        $this->resetKostInput();

        $this->emit('dataKostModified', ['message' => 'Data kost berhasil ditambahkan']);
    }

    public function resetKostInput()
    {
        $this->reset(['namaKost', 'alamatKost', 'biayaKost', 'jarakKost', 'luasKamarKost', 'fotoKost', 'statusData', 'thumbnail']);
    }
}
