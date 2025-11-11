@php
    use App\Components\Html;
    use App\Components\Helper;
    use App\Components\Session;
    use App\Constants\LayananConstant;
    use App\Http\Controllers\StandarPelayananController;

    /**
     * @var \Illuminate\Pagination\LengthAwarePaginator<int, \App\Models\Layanan> $allLayanan
     **/

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
                <?= Html::a('<i class="fa fa-file-pdf"></i> Export PDF SK', route(StandarPelayananController::ROUTE_EXPORT_PDF, [
                    'id_instansi' => request()->query('id_instansi')
                ]), [
                    'class' => 'btn btn-danger',
                    'target' => '_blank',
                ]) ?>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style="width:60px; text-align:center">No</th>
                            <th>Nama Layanan</th>
                            @if (Session::isAdmin())
                                <th style="width:400px;">Perangkat Daerah</th>
                            @endif
                            <?php /*
                            <th style="width:250px;">Deskripsi</th>
                            <th style="width:150px;">Pemicu</th>
                            <th style="width:150px;">Teknis</th>
                            <th style="width:180px;">Penerima Manfaat</th>
                            <th style="width:180px;">Produk</th>
                            <th style="width:120px; text-align:center">Persyaratan</th>
                            <th style="width:120px; text-align:center">Prosedur</th>
                            <th style="width:120px;">Biaya</th>
                            <th style="width:180px;">Kategori</th>
                            <th style="width:100px;">SOP</th>
                            <th style="width:220px;">Siklus</th>
                            <th style="width:120px;">SKM</th>
                            */ ?>
                            <th style="width:100px; text-align:center">Persen Pengisian</th>
                            <th style="width:80px; text-align:center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($allLayanan as $layanan)
                            <tr>
                                <td class="text-center">
                                    {{ $allLayanan->firstItem() + $loop->index }}
                                </td>
                                <td><?= Html::a($layanan->nama, route(LayananConstant::RouteView, ['id' => $layanan->id])) ?></td>
                                @if (Session::isAdmin())
                                    <td>{{ optional($layanan->instansi)->nama }}</td>
                                @endif
                                <?php /*
                                <td>{{ Str::limit($layanan->deskripsi, 120) }}</td>
                                <td>{{ optional($layanan->layananPemicu)->nama }}</td>
                                <td>{{ optional($layanan->layananTeknis)->nama }}</td>
                                <td>{{ optional($layanan->layananPenerimaManfaat)->nama }}</td>
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
                                <td>{{ optional($layanan->atributBiaya)->nama }}</td>
                                <td>{{ $layanan->atribut_kategori }}</td>
                                <td>{{ optional($layanan->atributSop)->nama }}</td>
                                <td>{{ optional($layanan->atributSiklusLayanan)->nama }}</td>
                                <td>{{ optional($layanan->atributSkm)->nama }}</td>
                                */ ?>
                                <td style="text-align: center">
                                    <?= Helper::rp($layanan->persen_komponen, 0, 2) ?>%
                                </td>
                                <td class="text-center">
                                    <?= Html::a('<i class="fa fa-eye"></i>', route(LayananConstant::RouteView, ['id' => $layanan->id]), [
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
                            @php
                                $colspan = 15;
                                if (Session::isAdmin()) $colspan++;
                            @endphp
                            <tr>
                                <td colspan="{{ $colspan }}" class="text-center">
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
