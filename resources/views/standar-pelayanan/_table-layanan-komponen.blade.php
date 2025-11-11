@php
    /**
     * @var \Illuminate\Support\Collection<\App\Models\LayananKomponen> $allLayananKomponen
     * @var \App\Models\RefLayananKomponen $listRefLayananKomponen
     **/
@endphp

<table class="table-bordered">
    <tr>
        <th style="text-align: center; width: 30px;">No</th>
        <th style="width: 200px;">Komponen</th>
        <th>Uraian</th>
    </tr>
    @foreach ($listRefLayananKomponen as $refLayananKommponen)
        <tr>
            <td style="text-align: center">
                {{ $loop->iteration }}
            </td>
            <td>
                {{ $refLayananKommponen->nama }}
            </td>
            <td>
                @php
                    $allLayananKomponenFiltered = $allLayananKomponen
                        ->where('id_ref_layanan_komponen', $refLayananKommponen->id)
                        ->sortBy('urutan');
                        
                    $jumlah = $allLayananKomponenFiltered->count();
                @endphp
                @if ($allLayananKomponenFiltered->isNotEmpty())
                    @if ($jumlah > 1) <ol style="margin-bottom:0"> @endif
                        @foreach ($allLayananKomponenFiltered as $item)
                            @if ($jumlah > 1) <li> @endif
                                {{ $item->uraian }}
                            @if ($jumlah > 1) </li> @endif
                        @endforeach
                    @if ($jumlah > 1) </ol> @endif
                @endif
            </td>
        </tr>
    @endforeach
</table>