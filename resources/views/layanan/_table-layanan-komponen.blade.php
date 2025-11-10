@php
    use App\Components\Html;
    use App\Constants\LayananKomponenConstant;

    /**
     * @var \App\Models\Layanan $model
     * @var \Illuminate\Support\Collection<\App\Models\LayananKomponen> $allLayananKomponen
     * @var \Illuminate\Support\Collection<\App\Models\RefLayananKomponen> $allRefLayananKomponen
     * @var int|null $id_standar_layanan
     */

    $id_standar_layanan = $id_standar_layanan ?? null;
@endphp

<table class="table table-bordered">
    <tr>
        <th style="text-align: center; width: 60px;">No</th>
        <th style="width: 300px;">Komponen</th>
        <th>Uraian</th>
    </tr>
    @foreach ($allRefLayananKomponen as $refLayananKomponen)
        <tr>
            <td style="text-align: center">{{ $loop->iteration }}</td>
            <td>
                {{ $refLayananKomponen->nama }}
                <?= Html::a('<i class="fa fa-plus"></i>', route(LayananKomponenConstant::RouteCreate, [
                    'id_layanan' => $model->id,
                    'id_ref_layanan_komponen' => $refLayananKomponen->id,
                    'id_standar_layanan' => $id_standar_layanan,
                ]), [
                    'data-toggle' => 'tooltip',
                    'data-title' => 'Tambah Uraian',
                ]) ?>
            </td>
            <td>
                @php
                    $allLayananKomponenFiltered = $allLayananKomponen
                        ->where('id_standar_layanan', $id_standar_layanan)
                        ->where('id_ref_layanan_komponen', $refLayananKomponen->id)
                        ->sortBy('urutan');

                    $jumlah = $allLayananKomponenFiltered->count();
                @endphp
                @if ($allLayananKomponenFiltered->isNotEmpty())
                    @if($jumlah > 1) <ol style="padding-left:20px;margin-bottom:0"> @endif
                        @foreach ($allLayananKomponenFiltered as $item)
                            @if($jumlah > 1) <li> @endif
                                {{ $item->uraian }}
                                <?= Html::a(
                                    '<i class="fa fa-pencil-alt"></i>',
                                    route(LayananKomponenConstant::RouteUpdate, ['id' => $item->id]),
                                    ['data-toggle' => 'tooltip', 'title' => 'Ubah']
                                ) ?>
                                <?= Html::a(
                                    '<i class="fa fa-trash"></i>',
                                    route(LayananKomponenConstant::RouteDelete, ['id' => $item->id]),
                                    [
                                        'data-toggle' => 'tooltip',
                                        'title' => 'Hapus',
                                        'data-method' => 'POST',
                                        'data-confirm' => 'Yakin ingin menghapus data?',
                                    ]
                                ) ?>
                            @if($jumlah > 1) </li> @endif
                        @endforeach
                    @if($jumlah > 1) </ol> @endif
                @endif
            </td>
        </tr>
    @endforeach
</table>
