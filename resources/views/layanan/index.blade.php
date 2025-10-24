@php
    use App\Components\Html;
    use App\Constants\LayananConstant;

    $breadcrumbs[] = 'Daftar Layanan';
@endphp

@extends(LayoutConstant::MAIN_LAYOUT)

@section('title', 'Daftar Layanan')

@section('content')

    @include('layanan._filter')

    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">Daftar Layanan</h3>
        </div>

        <div class="card-body">
            <div class="mb-3">
                <?= Html::a('<i class="fa fa-plus"></i> Tambah Layanan', route(LayananConstant::RouteCreate), [
                    'class' => 'btn btn-success',
                ]) ?>
            </div>

            <div style="overflow:auto">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style="width:60px; text-align:center">No</th>
                            <th>Nama Layanan</th>
                            <th style="width:200px;">Perangkat Daerah</th>
                            <th style="width:180px;">Pemicu</th>
                            <th style="width:180px;">Teknis</th>
                            <th style="width:180px;">Produk</th>
                            <th style="width:120px; text-align:center">Persyaratan</th>
                            <th style="width:120px; text-align:center">Prosedur</th>
                            <th style="width:120px; text-align:center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($allLayanan as $layanan)
                            <tr>
                                <td class="text-center">
                                    {{ $allLayanan->firstItem() + $loop->index }}
                                </td>
                                <td>
                                    <?= Html::a($layanan->nama, route(LayananConstant::RouteRead, ['id' => $layanan->id])) ?>
                                </td>
                                <td>{{ optional($layanan->instansi)->nama }}</td>
                                <td>{{ optional($layanan->layananPemicu)->nama }}</td>
                                <td>{{ optional($layanan->layananTeknis)->nama }}</td>
                                <td>{{ optional($layanan->layananProduk)->nama }}</td>
                                <td class="text-center">
                                    <span class="badge badge-{{ $layanan->status_atribut_persyaratan ? 'success' : 'secondary' }}">
                                        {{ $layanan->status_atribut_persyaratan ? 'Ya' : 'Tidak' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-{{ $layanan->status_atribut_prosedur ? 'success' : 'secondary' }}">
                                        {{ $layanan->status_atribut_prosedur ? 'Ya' : 'Tidak' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <?= Html::a('<i class="fa fa-eye"></i>', route(LayananConstant::RouteRead, ['id' => $layanan->id]), [
                                        'data-toggle' => 'tooltip',
                                        'title' => 'Lihat',
                                    ]) ?>

                                    <?= Html::a('<i class="fa fa-pencil-alt"></i>', route(LayananConstant::RouteUpdate, ['id' => $layanan->id]), [
                                        'data-toggle' => 'tooltip',
                                        'title' => 'Ubah',
                                    ]) ?>

                                    <?= Html::a('<i class="fa fa-trash"></i>', route(LayananConstant::RouteDelete, ['id' => $layanan->id]), [
                                        'data-toggle' => 'tooltip',
                                        'title' => 'Hapus',
                                        'data-method' => 'POST',
                                        'data-confirm' => 'Yakin ingin menghapus data?',
                                    ]) ?>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">
                                    Data Layanan tidak ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-2">
                {{ $allLayanan->links() }}
            </div>
        </div>
    </div>

@endsection

