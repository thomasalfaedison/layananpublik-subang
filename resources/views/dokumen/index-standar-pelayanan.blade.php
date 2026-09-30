@php
    use App\Components\Helper;
    use App\Components\Html;
    use App\Http\Controllers\DokumenController;
    use App\Models\Dokumen;

    $breadcrumbs[] = 'Daftar Standar Pelayanan';
@endphp

@extends(LayoutConstant::MAIN_LAYOUT)

@section('title', 'Daftar Standar Pelayanan')

@section('content')
    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">Daftar Standar Pelayanan</h3>
        </div>

        <div class="card-body">
            <div class="mb-3">
                <?= Html::a('<i class="fa fa-upload"></i> Unggah Standar Pelayanan', route(DokumenController::ROUTE_UPLOAD_FORM, [
                    'slug' => Dokumen::SLUG_STANDAR_PELAYANAN,
                ]), ['class' => 'btn btn-success']) ?>
            </div>

            <div style="overflow: auto">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style="width:60px; text-align:center">No</th>
                            <th style="width:90px; text-align:center">Tahun</th>
                            <th>Nomor Dokumen</th>
                            <th style="width:160px; text-align:center">Tanggal</th>
                            <th style="width:110px; text-align:center">File</th>
                            <th style="width:100px; text-align:center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($allDokumen as $dokumen)
                            <tr>
                                <td class="text-center">{{ $allDokumen->firstItem() + $loop->index }}</td>
                                <td class="text-center">{{ $dokumen->tahun ?? '-' }}</td>
                                <td>{{ $dokumen->nomor }}</td>
                                <td class="text-center">{{ $dokumen->tanggal ? Helper::getTanggal($dokumen->tanggal) : '-' }}</td>
                                <td class="text-center">
                                    @if ($dokumen->getFileUrl('file', Dokumen::FOLDER_FILE))
                                        <?= Html::a('<i class="fa fa-file"></i> Lihat File', $dokumen->getFileUrl('file', Dokumen::FOLDER_FILE), [
                                            'class' => 'btn btn-success btn-xs',
                                            'target' => '_blank',
                                        ]) ?>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <?= Html::a('<i class="fa fa-pencil-alt"></i>', route(DokumenController::ROUTE_UPDATE, ['id' => $dokumen->id]), [
                                        'data-toggle' => 'tooltip',
                                        'title' => 'Ubah dokumen',
                                    ]) ?>
                                    <?= Html::a('<i class="fa fa-trash"></i>', route(DokumenController::ROUTE_DELETE, ['id' => $dokumen->id]), [
                                        'data-toggle' => 'tooltip',
                                        'title' => 'Hapus dokumen',
                                        'data-method' => 'POST',
                                        'data-confirm' => 'Yakin ingin menghapus dokumen ini?',
                                    ]) ?>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Belum ada standar pelayanan yang diunggah.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-2">{{ $allDokumen->links() }}</div>
        </div>
    </div>
@endsection
