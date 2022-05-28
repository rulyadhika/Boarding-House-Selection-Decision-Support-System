@push('pageStyle')
    <style>
        .kost-card img {
            height: 100%;
            object-fit: cover;
        }

    </style>
@endpush

<div class="container">

    <h5 class="text-center mb-5">Cari Kost Yang Sesuai Dengan Kriteriamu</h5>

    <div class="row g-5">
        <div class="col-lg-4 p-0">

            <div class="border rounded p-4">

                <h5 class="fw-bold">Filter</h5>

                <hr>

                <span class="d-block fw-medium mb-2">Persentase Bobot</span>

                <div class="row mb-3">
                    <label for="harga" class="col-sm-5 col-form-label">Harga</label>
                    <div class="col-sm-7">
                        <div class="input-group">
                            <input type="number" class="form-control @error('persentaseBobot') is-invalid @enderror" id="harga" wire:model.defer="priceCriteriaWeight">
                            <span class="input-group-text" id="basic-addon1">%</span>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="jarak" class="col-sm-5 col-form-label">Jarak</label>
                    <div class="col-sm-7">
                        <div class="input-group">
                            <input type="number" wire:model.defer="distanceCriteriaWeight" class="form-control @error('persentaseBobot') is-invalid @enderror"
                                id="jarak">
                            <span class="input-group-text" id="basic-addon1">%</span>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="luas_kamar" class="col-sm-5 col-form-label">Luas Kamar</label>
                    <div class="col-sm-7">
                        <div class="input-group">
                            <input type="number" wire:model.defer="roomSizeCriteriaWeight" class="form-control @error('persentaseBobot') is-invalid @enderror"
                                id="luas_kamar">
                            <span class="input-group-text" id="basic-addon1">%</span>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="fasilitas" class="col-sm-5 col-form-label">Fasilitas</label>
                    <div class="col-sm-7">
                        <div class="input-group">
                            <input type="number" wire:model.defer="facilityCriteriaWeight" class="form-control @error('persentaseBobot') is-invalid @enderror"
                                id="fasilitas">
                            <span class="input-group-text" id="basic-addon1">%</span>
                        </div>
                    </div>
                </div>

                @error('persentaseBobot')
                    <small class="text-danger">{{ $message }}</small>
                @enderror

                <hr>

                <span class="d-block fw-medium mb-2">Kategori Kost</span>

                <select wire:model.defer="selectedCategory" class="form-select">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->nama_kategori }}</option>
                    @endforeach
                </select>

                <hr>

                <div class="mb-3">
                    <label for="rangeHarga" class="form-label">Range Harga</label>
                    <select wire:model.defer="selectedPriceCriteria" class="form-select" id="rangeHarga">
                        <option value="">-- Pilih Range Harga --</option>
                        @foreach ($priceCriteriaRange as $priceRange)
                            <option value="{{ $priceRange->id }}">
                                {{ 'Rp. '.$priceRange->batas_bawah . ' s/d ' . 'Rp. '.$priceRange->batas_atas }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="rangeJarak" class="form-label">Range Jarak</label>
                    <select wire:model.defer="selectedDistanceCriteria" class="form-select" id="rangeJarak">
                        <option value="">-- Pilih Range Jarak --</option>
                        @foreach ($distanceCriteriaRange as $distanceRange)
                            <option value="{{ $distanceRange->id }}">
                                {{ $distanceRange->batas_bawah .' m' . ' s/d ' . $distanceRange->batas_atas.' m' }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="rangeLuasKamar" class="form-label">Range Luas Kamar</label>
                    <select wire:model.defer="selectedRoomSizeCriteria" class="form-select" id="rangeLuasKamar">
                        <option value="">-- Pilih Range Luas Kamar --</option>
                        @foreach ($roomSizeCriteriaRange as $roomSizeRange)
                            <option value="{{ $roomSizeRange->id }}">
                                {{ $roomSizeRange->batas_bawah }} m&sup2
                                s/d
                                {{ $roomSizeRange->batas_atas }} m&sup2
                            </option>
                        @endforeach
                    </select>
                </div>

                <hr>

                <button class="btn btn-dark w-100" wire:click="calculate">Proses</button>
            </div>
        </div>
        <div class="col-lg-8">
            @if (count($rankedData) > 0)
                @foreach ($rankedData as $data)
                    <div class="card mb-3 kost-card">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="{{ asset('src/images/kost/' . $data['kost']['thumbnail']) }}"
                                    class="img-fluid rounded-start" alt="...">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title"> {{ $data['kost']['nama_kost'] }}</h5>
                                    <p class="card-text"> {{ $data['kost']['alamat_kost'] }}</p>

                                    <small class="d-block mb-1">
                                        <span class="fw-medium">Jenis Kost : </span>Kost
                                        {{ $data['kost']['category']['nama_kategori'] }}
                                    </small>

                                    <small class="d-block mb-1">
                                        <span class="fw-medium">Biaya : </span> Rp. {{ $data['kost']['biaya'] }}/bulan
                                    </small>

                                    <small class="d-block mb-1">
                                        <span class="fw-medium">Luas Kamar : </span>
                                        {{ $data['kost']['luas_kamar'] }} m<sup>2</sup>
                                    </small>

                                    <small class="d-block mb-1">
                                        <span class="fw-medium">Jarak Dari Kampus : </span>
                                        {{ $data['kost']['jarak'] }} m
                                    </small>

                                    <small class="d-block">
                                        <span class="fw-medium">Fasilitas : </span>
                                        {{ $data['kost']['facility']['nama_kriteria'] }}
                                    </small>

                                    <p class="card-text mt-2">
                                        <small class="text-muted">Nilai Rekomendasi :
                                            {{ $data['nilai_perhitungan'] }}</small>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                {{-- <div class="d-flex justify-content-end">
                    {{ $rankedData->links() }}
                </div> --}}
            @else
            <div class="p-3 border rounded text-center">
                <p class="mb-0">Kost yang memiliki kriteria seperti yang kamu cari tidak ditemukan. Coba ubah filter dan coba kembali</p>
            </div>
            @endif
        </div>
    </div>


</div>
