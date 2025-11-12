@php

use App\Components\Html;
use App\Constants\LayananKomponenConstant;

/* @see \App\Http\Controllers\LayananKomponenController::create() */
/* @see \App\Http\Controllers\LayananKomponenController::update() */
/* @var $model \App\Models\LayananKomponen */
/* @var $referrer string */
/* @var $action string */

    $backUrl = $referrer ?? route(LayananKomponenConstant::RouteIndex);
@endphp

<form action="{{ $action }}" method="POST">
    @csrf
    <input type="hidden" name="referrer" value="{{ $backUrl }}">

    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">Form Komponen Layanan: {{ $model->refLayananKomponen?->nama }}</h3>
        </div>

        <div class="card-body">

            <?php /*
            <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <?= Form::label('id_induk', 'Induk', ['required' => true]) ?>
                            <?= Form::select('id_induk', $listLayananKomponenInduk, old('id_induk', $model->id_induk), [
                                'class' => 'form-control' . ($errors->has('id_induk') ? ' is-invalid' : ''),
                                'placeholder' => '- Pilih Induk -',
                            ]) ?>
                            @error('id_induk')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                */ ?>

            @if ($model->id_layanan == null)    
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <?= Form::label('id_layanan', 'Layanan', ['required' => true]) ?>
                            <?= Form::select('id_layanan', $listLayanan, old('id_layanan', $model->id_layanan), [
                                'class' => 'form-control select2-field' . ($errors->has('id_layanan') ? ' is-invalid' : ''),
                                'placeholder' => '- Pilih Layanan -',
                            ]) ?>
                            @error('id_layanan')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            @endif

            @if ($model->id_ref_layanan_komponen == null)
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <?= Form::label('id_ref_layanan_komponen', 'Komponen', ['required' => true]) ?>
                            <?= Form::select('id_ref_layanan_komponen', $listRefLayananKomponen, old('id_ref_layanan_komponen', $model->id_ref_layanan_komponen), [
                                'class' => 'form-control select2-field' . ($errors->has('id_ref_layanan_komponen') ? ' is-invalid' : ''),
                                'placeholder' => '- Pilih Komponen -',
                            ]) ?>
                            @error('id_ref_layanan_komponen')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            @endif

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                            <?= Form::label('uraian', 'Uraian ' . $model->refLayananKomponen?->nama, ['required' => true]) ?>
                            <?= Form::textarea('uraian', old('uraian', $model->uraian), [
                            'class' => 'form-control' . ($errors->has('uraian') ? ' is-invalid' : ''),
                            'placeholder' => 'Tuliskan Uraian ' . $model->refLayananKomponen?->nama,
                            'rows' => 8,
                        ]) ?>
                        @error('uraian')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-6">
                    @if (!$model->exists)    
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <div class="alert alert-info">
                                Untuk memasukan lebih dari 1 data secara langsung silahkan gunakan
                                titik koma (;) pada akhir uraian, sebagai contoh:<br/>
                                Uraian 1;<br/>
                                Uraian 2;<br/>
                                Uraian 3
                            </div>
                        </div>
                    @endif
                </div>
            </div>


            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <?= Form::label('urutan', 'Urutan') ?>
                        <?= Form::number('urutan', old('urutan', $model->urutan), [
                            'class' => 'form-control' . ($errors->has('urutan') ? ' is-invalid' : ''),
                            'placeholder' => 'Contoh: 1',
                            'min' => 0,
                        ]) ?>
                        @error('urutan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer">
            <?= Html::submit('<i class="fa fa-save"></i> Simpan', [
                'class' => 'btn btn-success',
            ]) ?>

            <?= Html::a('<i class="fa fa-arrow-left"></i> Kembali', $backUrl, [
                'class' => 'btn btn-warning ml-2',
            ]) ?>
        </div>
    </div>
</form>
