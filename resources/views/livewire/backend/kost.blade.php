<div>
    <x-slot name="title">{{ $title }}</x-slot>

    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header d-flex flex-row py-3 align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Data Kost</h6>
                    <button class="btn btn-sm btn-primary add-kost-btn" data-toggle="modal" data-target="#kostModal"><i
                            class="fa fa-plus mr-1"></i> Tambah Data</button>
                </div>
                <!-- Card Body -->
                <div class="card-body" id="kost-wrapper">
                    <div class="table-responsive">
                        <table id="kost-table" class="display table" style="width:100%">
                            <thead class="thead-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Foto</th>
                                    <th>Nama Kost</th>
                                    <th>Jenis Kost</th>
                                    <th>Biaya</th>
                                    <th>Jarak</th>
                                    <th>Luas</th>
                                    <th>Fasilitas</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataKost as $data)
                                    <tr>
                                        <td>{{ $page * $amountData + $loop->iteration - $amountData }}</td>
                                        <td style="max-width: 100px;">
                                            @if (Storage::disk('public')->exists('src/images/kost/' . $data->thumbnail))
                                                <img src="{{ asset('src/images/kost/' . $data->thumbnail) }}"
                                                    class="img-fluid" alt="">
                                            @else
                                                <img src="{{ asset('src/images/kost/default.jpg') }}"
                                                    class="img-fluid" alt="">
                                            @endif
                                        </td>
                                        <td class="ellipsis" style="max-width: 150px;" title="{{ $data->nama_kost }}">{{ $data->nama_kost }}</td>
                                        <td>{{ $data->category->nama_kategori }}</td>
                                        <td>Rp. {{ $data->biaya }}</td>
                                        <td>{{ $data->jarak }} m</td>
                                        <td>{{ $data->luas_kamar }} m<sup>2</sup></td>
                                        <td class="ellipsis" style="max-width: 100px;" title="{{ $data->facility->nama_kriteria }}">{{ $data->facility->nama_kriteria }}</td>
                                        <td class="text-{{ $data->status == 'ditampilkan' ? 'success' : 'danger' }}">
                                            {{ Str::headline($data->status) }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-primary edit-kost-btn"
                                                data-id="{{ $data->id }}" data-toggle="modal" data-target="#kostModal">
                                                <i class="fa fa-pencil-alt"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger delete-kost-btn"
                                                data-id="{{ $data->id }}">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-end">
                        {{ $dataKost->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="kostModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="kostModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="kostModalLabel">Tambah Data Kost</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-4 mb-2 mb-lg-0">
                            <h6 class="d-block font-weight-bold">Foto Kost</h6>
                            @if ($fotoKost)
                                <img src="{{ $fotoKost->temporaryUrl() }}" alt="" class="img-fluid">
                            @else
                                <img src="{{ asset('src/images/kost/' . $thumbnail) }}" alt="" id="img-preview"
                                    class="img-fluid">
                            @endif

                            <div class="input-group @error('fotoKost') is-invalid @enderror mt-2">
                                <div class="custom-file" wire:ignore>
                                    <input type="file" class="custom-file-input" id="imageInput"
                                        wire:model.defer="fotoKost">
                                    <label class="custom-file-label" for="imageInput"
                                        aria-describedby="inputGroupFileAddon01">Choose file</label>
                                </div>
                            </div>
                            <small>*Ukuran file maksimal 1MB. Ekstensi yang diperbolehkan jpg/jpeg/png. </small>
                            @error('fotoKost')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-lg-8">
                            <div class="form-group">
                                <label for="statusData">Status Data</label>
                                <select id="statusData" class="form-control @error('statusData') is-invalid @enderror"
                                    wire:model.defer="statusData">
                                    <option value="">-- Pilih Status Data --</option>
                                    <option value="ditampilkan">Ditampilkan</option>
                                    <option value="diarsipkan">Diarsipkan</option>
                                </select>
                                @error('statusData')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="namaKost">Nama Kost</label>
                                <input type="text" class="form-control @error('namaKost') is-invalid @enderror"
                                    wire:model.defer="namaKost" id="namaKost">
                                @error('namaKost')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="kategoriKost">Jenis Kost</label>
                                <select class="form-control @error('kategoriKost') is-invalid @enderror"
                                    wire:model.defer="kategoriKost" id="kategoriKost" wire:model.defer="statusData">
                                    <option value="">-- Pilih Jenis Kost --</option>
                                    @foreach ($kostCategories as $category)
                                        <option value="{{ $category->id }}">{{ $category->nama_kategori }}</option>
                                    @endforeach
                                </select>
                                @error('kategoriKost')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="alamatKost">Alamat Kost</label>
                                <textarea type="text" class="form-control @error('alamatKost') is-invalid @enderror" id="alamatKost"
                                    wire:model.defer="alamatKost"></textarea>
                                @error('alamatKost')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="fasilitasKost">Fasilitas</label>
                                <select id="fasilitasKost" class="form-control @error('fasilitasKost') is-invalid @enderror"
                                    wire:model.defer="fasilitasKost">
                                    <option value="">-- Pilih Fasilitas --</option>
                                    @foreach ($facilityCriteria as $facility)
                                        <option value="{{ $facility->id }}">{{ $facility->nama_kriteria }}</option>
                                    @endforeach
                                </select>
                                @error('fasilitasKost')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="biayaKost">Biaya Kost</label>
                                    <div class="input-group @error('biayaKost') is-invalid @enderror">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Rp</div>
                                        </div>
                                        <input type="text" class="form-control @error('biayaKost') is-invalid @enderror"
                                            wire:model.defer="biayaKost" id="biayaKost">
                                    </div>
                                    @error('biayaKost')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="jarakKost">Jarak Kost</label>
                                    <div class="input-group @error('jarakKost') is-invalid @enderror">
                                        <input type="text" class="form-control @error('jarakKost') is-invalid @enderror"
                                            wire:model.defer="jarakKost" id="jarakKost">
                                        <div class="input-group-append">
                                            <div class="input-group-text">m</div>
                                        </div>
                                    </div>
                                    @error('jarakKost')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="luasKamarKost">Luas Kamar</label>
                                    <div class="input-group @error('luasKamarKost') is-invalid @enderror">
                                        <input type="text"
                                            class="form-control @error('luasKamarKost') is-invalid @enderror"
                                            wire:model.defer="luasKamarKost" id="luasKamarKost">
                                        <div class="input-group-append">
                                            <div class="input-group-text">m<sup>2</sup></div>
                                        </div>
                                    </div>
                                    @error('luasKamarKost')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" wire:ignore>
                    <button type="button" class="btn btn-sm btn-primary" wire:click="addKostData" id="store-kost-btn">
                        <i class="fa fa-save mr-1"></i>
                        Simpan</button>

                    <button type="button" class="btn btn-sm btn-primary" wire:click="updateKostData" id="update-kost-btn">
                        <i class="fa fa-save mr-1"></i>
                        Perbarui</button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('pageScript')
    <script>
        Livewire.on('dataKostModified', function(response) {
            dispatchSuccessDialog({
                title: "Berhasil!",
                text: response.message,
            });

            $("#kostModal").modal('hide');
        });
    </script>
    <script>
        $(".add-kost-btn").on("click", function() {
            Livewire.emit('resetKostInput');

            $("#kostModalLabel").text("Tambah Data Kost");

            $("#store-kost-btn").attr('hidden', false);
            $("#update-kost-btn").attr('hidden', true);

        });

        $("#kost-wrapper").on('click', '.edit-kost-btn', function() {
            Livewire.emit('resetKostInput');

            let dataId = $(this).data('id');
            $("#kostModalLabel").text("Ubah Data Kost");

            $("#store-kost-btn").attr('hidden', true);
            $("#update-kost-btn").attr('hidden', false);


            Livewire.emit('getKostData', dataId);
        });

        $("#kost-wrapper").on('click', '.delete-kost-btn', async function() {
            let dataId = $(this).data('id');

            let continueToDelete = await dispatchConfirmationDialog({
                title: "Apakah Kamu Yakin?",
                text: 'Untuk hapus data kost ini?',
                confirmButtonText: 'Hapus',
                showCancelButton: true
            });

            if (continueToDelete) {
                Livewire.emit('deleteKostData', dataId);
            }
        });
    </script>
@endpush
