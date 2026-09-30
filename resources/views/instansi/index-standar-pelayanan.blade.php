@php
    use App\Components\Helper;
    use App\Components\Html;
    use App\Components\Session;
    use App\Http\Controllers\DokumenController;

    $breadcrumbs[] = 'Daftar Standar Pelayanan';
@endphp

@extends(LayoutConstant::MAIN_LAYOUT)

@section('title', 'Daftar Standar Pelayanan Tahun ' . $tahun)

@section('content')

    @if (Session::isAdmin())
        @include('instansi._filter')
    @endif

    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">Daftar Perangkat Daerah</h3>
        </div>

        <div class="card-body">
            <div class="mb-3">
                <?= Html::a('<i class="fa fa-upload"></i> Unggah Standar Pelayanan', route(DokumenController::ROUTE_UPLOAD_FORM, [
                    'slug' => \App\Models\Dokumen::getSlugByJenis($jenisDokumen),
                    'tahun' => $tahun,
                ]), [
                    'class' => 'btn btn-success',
                ]) ?>
            </div>

            <div style="overflow: auto">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style="width:60px; text-align:center">No</th>
                            <th>Perangkat Daerah</th>
                            <th>Nomor Dokumen</th>
                            <th style="width:90px; text-align:center">Tahun</th>
                            <th style="width:160px; text-align:center">Tanggal</th>
                            <th style="width:110px; text-align:center">File</th>
                            <th style="width:100px; text-align:center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($allInstansi as $instansi)
                            @foreach (($instansi->dokumenItems->isEmpty() ? [null] : $instansi->dokumenItems) as $dokumen)
                                <tr>
                                    @if ($loop->first)
                                        <td class="text-center" rowspan="{{ max(1, $instansi->dokumenItems->count()) }}">
                                            {{ $allInstansi->firstItem() + $loop->parent->index }}
                                        </td>
                                        <td rowspan="{{ max(1, $instansi->dokumenItems->count()) }}">{{ $instansi->nama }}</td>
                                    @endif
                                    <td>{{ $dokumen->nomor ?? '-' }}</td>
                                    <td class="text-center">{{ $dokumen->tahun ?? '-' }}</td>
                                    <td class="text-center">{{ $dokumen?->tanggal ? Helper::getTanggal($dokumen->tanggal) : '-' }}</td>
                                    <td class="text-center">
                                        @if ($dokumen?->getFileUrl('file', \App\Models\Dokumen::FOLDER_FILE))
                                            <?= Html::a('<i class="fa fa-file"></i> Lihat File', $dokumen->getFileUrl('file', \App\Models\Dokumen::FOLDER_FILE), [
                                                'class' => 'btn btn-success btn-xs',
                                                'target' => '_blank',
                                            ]) ?>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($dokumen)
                                            <?= Html::a('<i class="fa fa-pencil-alt"></i>', route(DokumenController::ROUTE_UPDATE, ['id' => $dokumen->id]), [
                                                'data-toggle' => 'tooltip',
                                                'title' => 'Ubah',
                                            ]) ?>
                                            <?= Html::a('<i class="fa fa-trash"></i>', route(DokumenController::ROUTE_DELETE, ['id' => $dokumen->id]), [
                                                'data-toggle' => 'tooltip',
                                                'title' => 'Hapus',
                                                'data-method' => 'POST',
                                                'data-confirm' => 'Yakin ingin menghapus dokumen ini?',
                                            ]) ?>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">
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
