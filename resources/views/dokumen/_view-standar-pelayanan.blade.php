@php
    use App\Components\Helper;
    use App\Components\Html;
    use App\Http\Controllers\DokumenController;
    use App\Http\Controllers\StandarPelayananController;
@endphp

<div class="card card-default">
    <div class="card-header">
        <h3 class="card-title">Standar Pelayanan</h3>
    </div>
    <div class="card-body">
        @if (\App\Components\Session::isInstansi())
            @if ($dokumenModel->getFileUrl('file', \App\Models\Dokumen::FOLDER_FILE))
                <div class="alert alert-success">
                    Dokumen Standar Pelayanan sudah diunggah, silahkan klik lihat file untuk meninjau hasil file yang diunggah.
                </div>
            @else
                <div class="alert alert-danger">
                    Dokumen Standar Pelayanan belum diunggah! Silahkan unggah terlebih dahulu atau klik cek PDF SK untuk meninjau dokumen template.
                </div>
            @endif
        @endif

        <table class="table table-bordered">
            <tr>
                <th style="width:200px;">Perangkat Daerah</th>
                <td>{{ $standarPelayananModel->instansi?->nama ?? '-' }}</td>
            </tr>
            <tr>
                <th>Nomor Keputusan</th>
                <td>{{ $standarPelayananModel->nomor ?? '-' }}</td>
            </tr>
            <tr>
                <th>Alamat Kantor</th>
                <td>
                    @if ($standarPelayananModel->alamat)
                        {!! nl2br(e($standarPelayananModel->alamat)) !!}
                    @else
                        -
                    @endif
                </td>
            </tr>
            <tr>
                <th>Jabatan Penandatangan</th>
                <td>{{ $standarPelayananModel->jabatan_ttd ?? '-' }}</td>
            </tr>
            <tr>
                <th>Nama Penandatangan</th>
                <td>{{ $standarPelayananModel->nama_ttd ?? '-' }}</td>
            </tr>
            <tr>
                <th>NIP Penandatangan</th>
                <td>{{ $standarPelayananModel->nip_ttd ?? '-' }}</td>
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
            <tr>
                <th>Nomor Dokumen</th>
                <td>{{ $dokumenModel->nomor ?? '-' }}</td>
            </tr>
            <tr>
                <th>Tanggal Upload</th>
                <td>{{ $dokumenModel->tanggal ? Helper::getTanggal($dokumenModel->tanggal) : '-' }}</td>
            </tr>
        </table>
    </div>
    <div class="card-footer">
        <?= Html::a('<i class="fa fa-pencil-alt"></i> Ubah', route(StandarPelayananController::ROUTE_UPDATE, [
            'id' => $standarPelayananModel->id,
        ]), [
            'class' => 'btn btn-warning',
        ]) ?>

        <?= Html::a('<i class="fa fa-upload"></i> Unggah Dokumen', route(DokumenController::ROUTE_UPLOAD_FORM, [
            'slug' => $slug,
        ]), [
            'class' => 'btn btn-success ml-2',
        ]) ?>

        <?= Html::a('<i class="fa fa-file-pdf"></i> Cek PDF SK', route(StandarPelayananController::ROUTE_EXPORT_PDF, [
            'id_instansi' => $standarPelayananModel->id_instansi,
        ]), [
            'class' => 'btn btn-danger ml-2',
            'target' => '_blank',
        ]) ?>
    </div>
</div>
