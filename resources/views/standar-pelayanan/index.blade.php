@php
    use App\Components\Helper;
    use App\Components\Html;
    use App\Components\Session;
    use App\Http\Controllers\StandarPelayananController;

    /**
     * @var \Illuminate\Pagination\LengthAwarePaginator<int, \App\Models\StandarPelayanan> $allStandarPelayanan
     **/

    $breadcrumbs[] = 'Standar Pelayanan';

    $exportInstansiId = request()->query('id_instansi');

    if (Session::isInstansi()) {
        $exportInstansiId = Session::getIdInstansi();
    } elseif (!$exportInstansiId && $allStandarPelayanan->count() === 1) {
        $exportInstansiId = optional($allStandarPelayanan->first())->id_instansi;
    }
@endphp

@extends(LayoutConstant::MAIN_LAYOUT)

@section('title', 'Standar Pelayanan')

@section('content')

    @include('standar-pelayanan._filter')

    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">Daftar Standar Pelayanan</h3>
        </div>

        <div class="card-body">
            <div class="mb-3">
                <?= Html::a('<i class="fa fa-plus"></i> Tambah Standar Pelayanan', route(StandarPelayananController::ROUTE_CREATE), [
                    'class' => 'btn btn-success',
                ]) ?>

                @if ($exportInstansiId !== null)
                    <?= Html::a('<i class="fa fa-file-pdf"></i> Export PDF', route(StandarPelayananController::ROUTE_EXPORT_PDF, [
                        'id_instansi' => $exportInstansiId,
                    ]), [
                        'class' => 'btn btn-danger ml-2',
                        'target' => '_blank',
                    ]) ?>
                @endif
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style="width:60px; text-align:center">No</th>
                            @if (Session::isAdmin())
                                <th>Perangkat Daerah</th>
                            @endif
                            <th style="width:220px;">Nomor Keputusan</th>
                            <th style="width:250px;">Alamat</th>
                            <th style="width:220px;">Pejabat Penandatangan</th>
                            <th style="width:160px;">NIP</th>
                            <th style="width:120px; text-align:center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($allStandarPelayanan as $standar)
                            <tr>
                                <td class="text-center">
                                    {{ $allStandarPelayanan->firstItem() + $loop->index }}
                                </td>
                                @if (Session::isAdmin())
                                    <td>{{ optional($standar->instansi)->nama }}</td>
                                @endif
                                <td>{{ $standar->nomor ?? '-' }}</td>
                                <td>{{ $standar->alamat ? Helper::potongText($standar->alamat, 120) : '-' }}</td>
                                <td>
                                    <div class="font-weight-bold">{{ $standar->jabatan_ttd ?? '-' }}</div>
                                    <div>{{ $standar->nama_ttd ?? '-' }}</div>
                                </td>
                                <td>{{ $standar->nip_ttd ?? '-' }}</td>
                                <td class="text-center">
                                    <?= Html::a('<i class="fa fa-pencil-alt"></i>', route(StandarPelayananController::ROUTE_UPDATE, ['id' => $standar->id]), [
                                        'data-toggle' => 'tooltip',
                                        'title' => 'Ubah',
                                    ]) ?>
                                    <?= Html::a('<i class="fa fa-trash"></i>', route(StandarPelayananController::ROUTE_DELETE, ['id' => $standar->id]), [
                                        'data-toggle' => 'tooltip',
                                        'title' => 'Hapus',
                                        'data-method' => 'POST',
                                        'data-confirm' => 'Yakin ingin menghapus data?',
                                    ]) ?>
                                    <?= Html::a('<i class="fa fa-file-pdf"></i>', route(StandarPelayananController::ROUTE_EXPORT_PDF, [
                                        'id_instansi' => $standar->id_instansi,
                                    ]), [
                                        'data-toggle' => 'tooltip',
                                        'title' => 'Export PDF',
                                        'target' => '_blank',
                                    ]) ?>
                                </td>
                            </tr>
                        @empty
                            @php
                                $colspan = Session::isAdmin() ? 6 : 5;
                                $colspan += 1; // kolom aksi
                            @endphp
                            <tr>
                                <td colspan="{{ $colspan }}" class="text-center">
                                    Data Standar Pelayanan tidak ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-2">
                {{ $allStandarPelayanan->links() }}
            </div>
        </div>
    </div>

@endsection
