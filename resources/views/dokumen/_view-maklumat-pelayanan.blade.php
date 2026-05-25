@php
    use App\Components\Helper;
    use App\Components\Html;
    use App\Http\Controllers\DokumenController;
    use App\Http\Controllers\StandarPelayananController;
@endphp

<div class="card card-default">
    <div class="card-header">
        <h3 class="card-title">Maklumat Pelayanan</h3>
    </div>
    <div class="card-body">
        @if (\App\Components\Session::isInstansi())
            @if ($dokumenModel->getFileUrl('file', \App\Models\Dokumen::FOLDER_FILE))
                <div class="alert alert-success">
                    Dokumen Maklumat Pelayanan sudah diunggah, silahkan klik lihat file untuk meninjau hasil file yang diunggah.
                </div>
            @else
                <div class="alert alert-danger">
                    Dokumen Maklumat Pelayanan belum diunggah! Silahkan unggah terlebih dahulu atau klik export word untuk mengunduh dokumen template.
                </div>
            @endif
        @endif

        <table class="table table-bordered">
            <tr>
                <th style="width:200px;">Perangkat Daerah</th>
                <td>{{ $dokumenModel->instansi?->nama ?? '-' }}</td>
            </tr>
            <tr>
                <th>Nomor Dokumen</th>
                <td>{{ $dokumenModel->nomor ?? '-' }}</td>
            </tr>
            <tr>
                <th>Tanggal Dokumen</th>
                <td>{{ $dokumenModel->tanggal ? Helper::getTanggal($dokumenModel->tanggal) : '-' }}</td>
            </tr>
            <tr>
                <th>File Dokumen</th>
                <td>
                    @if ($dokumenModel->getFileUrl('file', \App\Models\Dokumen::FOLDER_FILE))
                        <?= Html::a('<i class="fa fa-file"></i> Lihat File', $dokumenModel->getFileUrl('file', \App\Models\Dokumen::FOLDER_FILE), [
                            'class' => 'btn btn-success btn-sm',
                            'target' => '_blank',
                        ]) ?>
                    @else
                        -
                    @endif
                </td>
            </tr>
        </table>
    </div>
    <div class="card-footer">
        <?= Html::a('<i class="fa fa-upload"></i> Unggah Dokumen', route(DokumenController::ROUTE_UPLOAD_FORM, [
            'slug' => $slug,
        ]), [
            'class' => 'btn btn-success',
        ]) ?>

        <?= Html::a('<i class="fa fa-file-word"></i> Export Word', route(StandarPelayananController::ROUTE_EXPORT_WORD_MAKLUMAT_PELAYANAN, [
            'id_instansi' => $dokumenModel->id_instansi,
        ]), [
            'class' => 'btn btn-primary ml-2',
        ]) ?>
    </div>
</div>
