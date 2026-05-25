@php
    use App\Components\Html;
    use App\Components\Session;
    use App\Http\Controllers\InstansiController;

    $judulDokumen = [
        \App\Models\Dokumen::JENIS_SP => 'Standar Pelayanan',
        \App\Models\Dokumen::JENIS_BA => 'Berita Acara',
        \App\Models\Dokumen::JENIS_MP => 'Maklumat Pelayanan',
    ][$jenisDokumen] ?? 'Dokumen';
@endphp

<form action="{{ route(InstansiController::ROUTE_UPLOAD_DOKUMEN) }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">Form Unggah {{ $judulDokumen }}</h3>
        </div>

        <div class="card-body">
            <div class="col-sm-6 pl-0">
                @if (Session::isInstansi())
                    <div class="form-group">
                        <?= Form::label('instansi_label_' . $jenisDokumen, 'Perangkat Daerah') ?>
                        <input type="text" class="form-control" value="{{ optional(auth()->user()->instansi)->nama }}" disabled>
                    </div>
                @else
                    <div class="form-group">
                        <?= Form::label('id_instansi', 'Perangkat Daerah', ['required' => true]) ?>
                        <?= Form::select('id_instansi', $listInstansiDokumen, old('id_instansi'), [
                            'class' => 'form-control select2-field' . ($errors->has('id_instansi') ? ' is-invalid' : ''),
                            'placeholder' => '- Pilih Perangkat Daerah -',
                        ]) ?>
                        @error('id_instansi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                @endif

                <div class="form-group">
                    <?= Form::label('nomor', 'Nomor ' . $judulDokumen, ['required' => true]) ?>
                    <?= Form::text('nomor', old('nomor'), [
                        'class' => 'form-control' . ($errors->has('nomor') ? ' is-invalid' : ''),
                        'placeholder' => 'Masukkan nomor dokumen',
                    ]) ?>
                    @error('nomor')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <?= Form::label('tanggal', 'Tanggal Dokumen', ['required' => true]) ?>
                    <?= Form::date('tanggal', old('tanggal'), [
                        'class' => 'form-control' . ($errors->has('tanggal') ? ' is-invalid' : ''),
                    ]) ?>
                    @error('tanggal')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <?= Form::label('file', 'File Dokumen', ['required' => true]) ?>
                    <input type="file" name="file" class="form-control{{ $errors->has('file') ? ' is-invalid' : '' }}" accept=".pdf,.doc,.docx">
                    <small class="form-text text-muted">Format file: PDF, DOC, DOCX. Maksimal 5 MB.</small>
                    @error('file')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <?= Form::hidden('jenis', $jenisDokumen) ?>
            <?= Form::hidden('referrer', old('referrer', $referrer)) ?>
        </div>

        <div class="card-footer">
            <?= Html::submit('<i class="fa fa-check"></i> Simpan', [
                'class' => 'btn btn-success',
                'type' => 'submit',
            ]) ?>
        </div>
    </div>
</form>
