@php
    use App\Components\Html;
    use App\Components\Helper;
    use App\Constants\BeritaAcaraConstant;
    use App\Constants\InstansiConstant;

    $breadcrumbs[] = "Berita Acara";
@endphp

@extends(LayoutConstant::MAIN_LAYOUT)

@section('title', "Berita Acara")

@section('content')

    @include('instansi._card-filter-berita-acara')

    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">Daftar Perangkat Daerah</h3>
        </div>

        <div class="card-body">

            <div class="mb-3">
                <?php /*
                <?= Html::a('<i class="fa fa-plus"></i> Tambah Berita Acara', route(BeritaAcaraConstant::RouteCreate), [
                    'class' => 'btn btn-success',
                ]) ?>
                */ ?>
                <?= Html::a('<i class="fa fa-file-excel"></i> Export Excel', route(BeritaAcaraConstant::RouteExportExcelAll, request()->query()), [
                    'class' => 'btn btn-success'
                ]) ?>
            </div>

            <div style="overflow: auto">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style="width:60px; text-align:center">No</th>
                            <th>Perangkat Daerah</th>
                            <th style="width:180px;">Tanggal Pelaksanaan</th>
                            <th style="width:70px; text-align:center"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($allInstansi as $instansi)
                            @php
                                $beritaAcara = $instansi->beritaAcara;
                            @endphp
                            <tr>
                                <td style="text-align: center;">
                                    {{ $allInstansi->firstItem() + $loop->index }}
                                </td>
                                <td>
                                    {!! Html::a($instansi->nama, route(BeritaAcaraConstant::RouteRead,[
                                        'id' => $beritaAcara->id,
                                    ])) !!}
                                </td>
                                <td>
                                    {{ Helper::getTanggal($beritaAcara?->tanggal_pelaksanaan) }}
                                </td>
                                <td class="text-center">
                                    <?= Html::a('<i class="fa fa-eye"></i>',  route(BeritaAcaraConstant::RouteRead, ['id' => $beritaAcara->id]), [
                                        'data-toggle' => 'tooltip',
                                        'title' => 'Lihat',
                                    ]) ?>

                                    @can('update', $beritaAcara)
                                        <?= Html::a('<i class="fa fa-pencil-alt"></i>',  route(BeritaAcaraConstant::RouteUpdate, ['id' => $beritaAcara->id]), [
                                            'data-toggle' => 'tooltip',
                                            'title' => 'Ubah',
                                        ]) ?>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">
                                    Data perangkat daerah tidak ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-2">
                {{ $allInstansi->links() }}
            </div>

        </div>
    </div>

@endsection