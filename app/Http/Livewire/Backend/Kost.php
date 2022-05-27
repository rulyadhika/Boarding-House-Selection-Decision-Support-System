<?php

namespace App\Http\Livewire\Backend;

use App\Models\CriteriaDistance;
use App\Models\CriteriaPrice;
use App\Models\CriteriaRoomSize;
use App\Models\Kost as ModelsKost;
use App\Models\KostCategory;
use App\Models\KostMatrix;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Kost extends Component
{
    use WithFileUploads;

    public $title;
    protected $dataKost = [];
    public $kostCategories = [];
    public $thumbnail = 'default.jpg';
    public $amountData = 10;

    // for store or update data
    public $idKost;
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
        'resetKostInput',
        'deleteKostData'
    ];

    protected $rules = [
        'kategoriKost' => 'required|exists:kost_categories,id',
        'namaKost' => 'required',
        'alamatKost' => 'required',
        'biayaKost' => 'required',
        'jarakKost' => 'required',
        'luasKamarKost' => 'required',
        'statusData' => 'required|in:ditampilkan,diarsipkan',
        'fotoKost' => 'image|max:1024'
    ];

    public function mount()
    {
        $this->title = 'Kelola Kost';

        $this->dataKost = ModelsKost::with('category')->orderBy('created_at', 'DESC')->paginate($this->amountData);
        $this->kostCategories = KostCategory::all();
    }

    public function render(Request $request)
    {
        $data = [
            'dataKost' => $this->dataKost,
            'page' => $request->page ?: 0
        ];

        return view('livewire.backend.kost', $data)->layout('layouts.backend');
    }

    public function getKostData($kostId)
    {
        $kostData = ModelsKost::find($kostId);

        if ($kostData == null) {
            return $this->emit('failedAction', ['message' => 'Data kost tidak ditemukan. Silahkan refresh halaman dan coba lagi', 'refresh' => true]);
        }

        $this->fill([
            'idKost' => $kostData->id,
            'namaKost' => $kostData->nama_kost,
            'alamatKost' => $kostData->alamat_kost,
            'biayaKost' => $kostData->biaya,
            'jarakKost' => $kostData->jarak,
            'luasKamarKost' => $kostData->luas_kamar,
            'thumbnail' => $kostData->thumbnail,
            'statusData' => $kostData->status,
            'kategoriKost' => $kostData->id_kategori
        ]);
    }

    public function addKostData()
    {
        $this->rules['fotoKost'] = 'required|' . $this->rules['fotoKost'];
        $validatedData = $this->validationInputKost();

        $photoName = uniqid() . '.' .  $this->fotoKost->extension();

        // move image to temp file
        $this->fotoKost->storeAs('src/images/kost', $photoName, 'public');

        $kost = ModelsKost::create([
            'id_kategori' => $this->kategoriKost,
            'nama_kost' => $this->namaKost,
            'alamat_kost' => $this->alamatKost,
            'biaya' => $this->biayaKost,
            'jarak' => $this->jarakKost,
            'luas_kamar' => $this->luasKamarKost,
            'kriteria_fasilitas' => 3,
            'thumbnail' => $photoName,
            'status' => $this->statusData
        ]);

        KostMatrix::create([
            'id_kost' => $kost->id,
            'biaya' => $validatedData['biaya'],
            'jarak' => $validatedData['jarak'],
            'luas_kamar' => $validatedData['luas_kamar'],
            'fasilitas' => 3,
        ]);

        $this->dataKost = ModelsKost::with('category')->orderBy('created_at', 'DESC')->paginate($this->amountData);

        $this->resetKostInput();

        $this->emit('dataKostModified', ['message' => 'Data kost berhasil ditambahkan']);
    }

    public function updateKostData()
    {
        $this->rules['fotoKost'] = 'nullable|' . $this->rules['fotoKost'];

        $validatedData = $this->validationInputKost();

        $kost = ModelsKost::find($this->idKost);

        if ($this->fotoKost) {
            if (Storage::disk('public')->exists('src/images/kost/' . $this->thumbnail)) {
                Storage::disk('public')->delete('src/images/kost/' . $this->thumbnail);
            }

            $photoName = uniqid() . '.' . $this->fotoKost->extension();

            $this->fotoKost->storeAs('src/images/kost', $photoName, 'public');
        } else {
            $photoName = $kost->thumbnail;
        }

        $kost->update([
            'id_kategori' => $this->kategoriKost,
            'nama_kost' => $this->namaKost,
            'alamat_kost' => $this->alamatKost,
            'biaya' => $this->biayaKost,
            'jarak' => $this->jarakKost,
            'luas_kamar' => $this->luasKamarKost,
            'kriteria_fasilitas' => 3,
            'thumbnail' => $photoName,
            'status' => $this->statusData
        ]);

        $kost->matrix()->update([
            'biaya' => $validatedData['biaya'],
            'jarak' => $validatedData['jarak'],
            'luas_kamar' => $validatedData['luas_kamar'],
            'fasilitas' => 3,
        ]);

        $this->dataKost = ModelsKost::with('category')->orderBy('created_at', 'DESC')->paginate($this->amountData);

        $this->resetKostInput();

        $this->emit('dataKostModified', ['message' => 'Data kost berhasil diperbarui']);
    }

    public function deleteKostData($kostId)
    {
        $kost = ModelsKost::find($kostId);

        if (Storage::disk('public')->exists('src/images/kost/' . $kost->thumbnail)) {
            Storage::disk('public')->delete('src/images/kost/' . $kost->thumbnail);
        }

        $kost->delete();

        $this->dataKost = ModelsKost::with('category')->orderBy('created_at', 'DESC')->paginate($this->amountData);

        $this->emit('dataKostModified', ['message' => 'Data kost berhasil dihapus']);
    }

    public function resetKostInput()
    {
        $this->reset(['namaKost', 'alamatKost', 'biayaKost', 'jarakKost', 'luasKamarKost', 'fotoKost', 'statusData', 'thumbnail']);
    }

    private function validationInputKost()
    {
        $this->validate();

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

        return ['biaya' => $biaya, 'jarak' => $jarak, 'luas_kamar' => $luas_kamar];
    }
}
