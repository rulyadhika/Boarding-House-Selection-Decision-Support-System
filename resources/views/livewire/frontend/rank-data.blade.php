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

    <div style="display: blodk">
        <select wire:model.defer="selectedPriceCriteria">
            <option value="-">-- Pilih Range Harga --</option>
            @foreach ($priceCriteriaRange as $priceRange)
                <option value="{{ $priceRange->id }}">
                    {{ $priceRange->batas_bawah . ' s/d ' . $priceRange->batas_atas }}</option>
            @endforeach
        </select>

        <select wire:model.defer="selectedDistanceCriteria">
            <option value="-">-- Pilih Range Jarak --</option>
            @foreach ($distanceCriteriaRange as $distanceRange)
                <option value="{{ $distanceRange->id }}">
                    {{ $distanceRange->batas_bawah . ' s/d ' . $distanceRange->batas_atas }}</option>
            @endforeach
        </select>

        <select wire:model.defer="selectedRoomSizeCriteria">
            <option value="-">-- Pilih Range Luas Kamar --</option>
            @foreach ($roomSizeCriteriaRange as $roomSizeRange)
                <option value="{{ $roomSizeRange->id }}">
                    {{ $roomSizeRange->batas_bawah . ' s/d ' . $roomSizeRange->batas_atas }}</option>
            @endforeach
        </select>
    </div>

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
