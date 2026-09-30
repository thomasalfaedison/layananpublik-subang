@php
    use App\Components\Helper;
    use App\Components\Html;
    use App\Http\Controllers\DokumenController;
    use App\Http\Controllers\StandarPelayananController;
    use App\Models\Dokumen;

    $breadcrumbs[] = 'Daftar Berita Acara';
@endphp

@extends(LayoutConstant::MAIN_LAYOUT)

@section('title', 'Daftar Berita Acara')

@section('content')
    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">Daftar Berita Acara</h3>
        </div>

        <div class="card-body">
            <div class="mb-3">
                <?= Html::a('<i class="fa fa-upload"></i> Unggah Berita Acara', route(DokumenController::ROUTE_UPLOAD_FORM, [
                    'slug' => Dokumen::SLUG_BERITA_ACARA,
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
                            <th style="width:80px; text-align:center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($allDokumen as $dokumen)
                            <tr>
                                <td class="text-center">{{ $allDokumen->firstItem() + $loop->index }}</td>
                                <td class="text-center">{{ $dokumen->tahun }}</td>
                                <td>{{ $dokumen->nomor ?? '-' }}</td>
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
                                    <?= Html::a('<i class="fa fa-file-word"></i>', route(StandarPelayananController::ROUTE_EXPORT_WORD_BERITA_ACARA, [
                                        'id_instansi' => $dokumen->id_instansi,
                                    ]), [
                                        'data-toggle' => 'tooltip',
                                        'title' => 'Export Word',
                                    ]) ?>
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
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Belum ada berita acara yang diunggah.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-2">{{ $allDokumen->links() }}</div>
        </div>
    </div>
@endsection
