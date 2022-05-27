<div>
    <select wire:model.defer="selectedCategory">
        <option value="-">-- Pilih Kategori --</option>
        @foreach ($categories as $category)
            <option value="{{ $category->id }}">{{ $category->nama_kategori }}</option>
        @endforeach
    </select>

    <input type="text" wire:model.defer="priceCriteriaWeight" placeholder="harga">
    <input type="text" wire:model.defer="distanceCriteriaWeight" placeholder="jarak">
    <input type="text" wire:model.defer="roomSizeCriteriaWeight" placeholder="luas kamar">
    <input type="text" wire:model.defer="facilityCriteriaWeight" placeholder="fasilitas">

    <button wire:click="calculate">proses</button>

    <table width="100%">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama Kos</th>
                <th>Harga</th>
                <th>Jarak</th>
                <th>Luas Kamar</th>
                <th>Fasilitas</th>
                <th>Skor</th>
            </tr>
        </thead>
        <tbody>
            @if (count($rankedData) > 0)
                @foreach ($rankedData->sortByDesc('nilai_perhitungan') as $data)
                    <tr>
                        <td>
                            {{ $loop->iteration }}
                        </td>
                        <td>
                            {{ $data['kost']['nama_kost'] }}
                        </td>
                        <td>
                            {{ $data['kost']['biaya'] }}
                        </td>
                        <td>
                            {{ $data['kost']['jarak'] }}
                        </td>
                        <td>
                            {{ $data['kost']['luas_kamar'] }}
                        </td>
                        <td>
                            {{ $data['kost']['facility']['nama_kriteria'] }}
                        </td>
                        <td>
                            {{ $data['nilai_perhitungan'] }}
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
