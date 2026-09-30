@php
    use App\Components\Html;
    use App\Components\Session;
    use App\Http\Controllers\DokumenController;

    $judulDokumen = \App\Models\Dokumen::getLabelByJenis($jenisDokumen);
    $isEditing = isset($dokumenModel);
    $tahunTerkunci = $isEditing && $dokumenModel->tahun !== null;
@endphp

<form action="{{ $isEditing ? route(DokumenController::ROUTE_UPDATE_PROCESS, ['id' => $dokumenModel->id]) : route(DokumenController::ROUTE_UPLOAD, ['slug' => $slug]) }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">Form {{ $isEditing ? 'Ubah' : 'Unggah' }} {{ $judulDokumen }}</h3>
        </div>

        <div class="card-body">
            <div class="col-sm-6 pl-0">
                @if (Session::isInstansi() || $isEditing)
                    <div class="form-group">
                        <?= Form::label('instansi_label_' . $jenisDokumen, 'Perangkat Daerah') ?>
                        <input type="text" class="form-control" value="{{ $isEditing ? $dokumenModel->instansi?->nama : optional(auth()->user()->instansi)->nama }}" disabled>
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

                @if ($tahun !== null || $jenisDokumen === \App\Models\Dokumen::JENIS_SP)
                    <div class="form-group">
                        <?= Form::label('tahun', 'Tahun Dokumen', $tahunTerkunci ? [] : ['required' => true]) ?>
                        <?= Form::number('tahun', $tahunTerkunci ? $dokumenModel->tahun : old('tahun', $tahun ?? Session::getTahun()), [
                            'class' => 'form-control' . ($errors->has('tahun') ? ' is-invalid' : ''),
                            'min' => 1901,
                            'max' => 2155,
                            ...($tahunTerkunci ? ['disabled' => 'disabled'] : ['required' => 'required']),
                        ]) ?>
                        @error('tahun')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                @endif

                <div class="form-group">
                    <?= Form::label('nomor', 'Nomor ' . $judulDokumen, ['required' => true]) ?>
                    <?= Form::text('nomor', old('nomor', $dokumenModel->nomor ?? null), [
                        'class' => 'form-control' . ($errors->has('nomor') ? ' is-invalid' : ''),
                        'placeholder' => 'Masukkan nomor dokumen',
                    ]) ?>
                    @error('nomor')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <?= Form::label('tanggal', 'Tanggal Dokumen', ['required' => true]) ?>
                    <?= Form::date('tanggal', old('tanggal', $dokumenModel->tanggal ?? null), [
                        'class' => 'form-control' . ($errors->has('tanggal') ? ' is-invalid' : ''),
                    ]) ?>
                    @error('tanggal')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <?= Form::label('file', 'File Dokumen', $isEditing ? [] : ['required' => true]) ?>
                    <input type="file" name="file" class="form-control{{ $errors->has('file') ? ' is-invalid' : '' }}" accept=".pdf,.doc,.docx">
                    <small class="form-text text-muted">Format file: PDF, DOC, DOCX. Maksimal 5 MB.</small>
                    @if ($isEditing && $dokumenModel->getFileUrl('file', \App\Models\Dokumen::FOLDER_FILE))
                        <small class="form-text text-muted">Kosongkan jika tidak ingin mengganti file.</small>
                    @endif
                    @error('file')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

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
