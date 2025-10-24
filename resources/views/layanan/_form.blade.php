<?php

use App\Components\Html;
use App\Components\Session;

/* @var $model \App\Models\Layanan */
/* @var $referrer string */
/* @var $action string */
/* @var $listInstansi array */
/* @var $listRefLayananPemicu array */
/* @var $listRefLayananTeknis array */
/* @var $listRefLayananPenerimaManfaat array */
/* @var $listRefLayananProduk array */
/* @var $listRefAtributBiaya array */
/* @var $listRefAtributSop array */
/* @var $listRefAtributSiklusLayanan array */
/* @var $listRefAtributSkm array */

$statusAtributPersyaratan = old('status_atribut_persyaratan', $model->status_atribut_persyaratan);
$statusAtributProsedur = old('status_atribut_prosedur', $model->status_atribut_prosedur);

?>

<form action="{{ $action }}" method="POST">
    @csrf
    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">Form Layanan</h3>
        </div>

        <div class="card-body">
            <div class="row">
                @if (Session::isAdmin())    
                    <div class="col-sm-6">
                        <div class="form-group">
                            <?= Form::label('id_instansi', 'Perangkat Daerah', ['required' => true]) ?>
                            <?= Form::select('id_instansi', $listInstansi, old('id_instansi', $model->id_instansi), [
                                'class' => 'form-control select2-field' . ($errors->has('id_instansi') ? ' is-invalid' : ''),
                                'placeholder' => '- Pilih Perangkat Daerah -'
                            ]) ?>
                            @error('id_instansi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                @endif
                <div class="col-sm-6">
                    <div class="form-group">
                        <?= Form::label('nama', 'Nama Layanan', ['required' => true]) ?>
                        <?= Form::text('nama', old('nama', $model->nama), [
                            'class' => 'form-control' . ($errors->has('nama') ? ' is-invalid' : ''),
                            'placeholder' => 'Masukkan nama layanan'
                        ]) ?>
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <?= Form::label('deskripsi', 'Deskripsi') ?>
                        <?= Form::textarea('deskripsi', old('deskripsi', $model->deskripsi), [
                            'class' => 'form-control' . ($errors->has('deskripsi') ? ' is-invalid' : ''),
                            'placeholder' => 'Masukkan deskripsi layanan',
                            'rows' => 3,
                        ]) ?>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <h5 class="mt-4 mb-3">Ciri Layanan</h5>

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <?= Form::label('id_ref_layanan_pemicu', 'Pemicu Layanan') ?>
                        <?= Form::select('id_ref_layanan_pemicu', $listRefLayananPemicu, old('id_ref_layanan_pemicu', $model->id_ref_layanan_pemicu), [
                            'class' => 'form-control' . ($errors->has('id_ref_layanan_pemicu') ? ' is-invalid' : ''),
                            'placeholder' => '- Pilih Pemicu Layanan -'
                        ]) ?>
                        @error('id_ref_layanan_pemicu')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <?= Form::label('id_ref_layanan_teknis', 'Teknis Layanan') ?>
                        <?= Form::select('id_ref_layanan_teknis', $listRefLayananTeknis, old('id_ref_layanan_teknis', $model->id_ref_layanan_teknis), [
                            'class' => 'form-control' . ($errors->has('id_ref_layanan_teknis') ? ' is-invalid' : ''),
                            'placeholder' => '- Pilih Teknis Layanan -'
                        ]) ?>
                        @error('id_ref_layanan_teknis')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <?= Form::label('id_ref_layanan_penerima_manfaat', 'Penerima Manfaat') ?>
                        <?= Form::select('id_ref_layanan_penerima_manfaat', $listRefLayananPenerimaManfaat, old('id_ref_layanan_penerima_manfaat', $model->id_ref_layanan_penerima_manfaat), [
                            'class' => 'form-control' . ($errors->has('id_ref_layanan_penerima_manfaat') ? ' is-invalid' : ''),
                            'placeholder' => '- Pilih Penerima Manfaat -'
                        ]) ?>
                        @error('id_ref_layanan_penerima_manfaat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <?= Form::label('id_ref_layanan_produk', 'Produk Layanan') ?>
                        <?= Form::select('id_ref_layanan_produk', $listRefLayananProduk, old('id_ref_layanan_produk', $model->id_ref_layanan_produk), [
                            'class' => 'form-control' . ($errors->has('id_ref_layanan_produk') ? ' is-invalid' : ''),
                            'placeholder' => '- Pilih Produk Layanan -'
                        ]) ?>
                        @error('id_ref_layanan_produk')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <h5 class="mt-4 mb-3">Atribut</h5>

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <div class="form-check">
                            <?= Form::checkbox('status_atribut_persyaratan', 1, (int) $statusAtributPersyaratan === 1, [
                                'class' => 'form-check-input',
                                'id' => 'status_atribut_persyaratan',
                            ]) ?>
                            <?= Form::label('status_atribut_persyaratan', 'Memiliki Persyaratan', ['class' => 'form-check-label']) ?>
                        </div>
                        @error('status_atribut_persyaratan')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <div class="form-check">
                            <?= Form::checkbox('status_atribut_prosedur', 1, (int) $statusAtributProsedur === 1, [
                                'class' => 'form-check-input',
                                'id' => 'status_atribut_prosedur',
                            ]) ?>
                            <?= Form::label('status_atribut_prosedur', 'Memiliki Prosedur', ['class' => 'form-check-label']) ?>
                        </div>
                        @error('status_atribut_prosedur')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <?= Form::label('id_ref_atribut_biaya', 'Biaya Layanan') ?>
                        <?= Form::select('id_ref_atribut_biaya', $listRefAtributBiaya, old('id_ref_atribut_biaya', $model->id_ref_atribut_biaya), [
                            'class' => 'form-control' . ($errors->has('id_ref_atribut_biaya') ? ' is-invalid' : ''),
                            'placeholder' => '- Pilih Biaya Layanan -'
                        ]) ?>
                        @error('id_ref_atribut_biaya')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <?= Form::label('atribut_kategori', 'Kategori Atribut') ?>
                        <?= Form::text('atribut_kategori', old('atribut_kategori', $model->atribut_kategori), [
                            'class' => 'form-control' . ($errors->has('atribut_kategori') ? ' is-invalid' : ''),
                            'placeholder' => 'Masukkan kategori atribut'
                        ]) ?>
                        @error('atribut_kategori')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <?= Form::label('id_ref_atribut_sop', 'SOP Layanan') ?>
                        <?= Form::select('id_ref_atribut_sop', $listRefAtributSop, old('id_ref_atribut_sop', $model->id_ref_atribut_sop), [
                            'class' => 'form-control' . ($errors->has('id_ref_atribut_sop') ? ' is-invalid' : ''),
                            'placeholder' => '- Pilih SOP Layanan -'
                        ]) ?>
                        @error('id_ref_atribut_sop')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <?= Form::label('id_ref_atribut_siklus_layanan', 'Siklus Layanan') ?>
                        <?= Form::select('id_ref_atribut_siklus_layanan', $listRefAtributSiklusLayanan, old('id_ref_atribut_siklus_layanan', $model->id_ref_atribut_siklus_layanan), [
                            'class' => 'form-control' . ($errors->has('id_ref_atribut_siklus_layanan') ? ' is-invalid' : ''),
                            'placeholder' => '- Pilih Siklus Layanan -'
                        ]) ?>
                        @error('id_ref_atribut_siklus_layanan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <?= Form::label('id_ref_atribut_skm', 'Atribut SKM') ?>
                        <?= Form::select('id_ref_atribut_skm', $listRefAtributSkm, old('id_ref_atribut_skm', $model->id_ref_atribut_skm), [
                            'class' => 'form-control' . ($errors->has('id_ref_atribut_skm') ? ' is-invalid' : ''),
                            'placeholder' => '- Pilih Atribut SKM -'
                        ]) ?>
                        @error('id_ref_atribut_skm')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <?= Form::hidden('referrer', old('referrer', $referrer)) ?>
        </div>

        <div class="card-footer">
            <div class="col-sm-offset-2 col-sm-3">
                <?= Html::submit('<i class="fa fa-check"></i> Simpan', [
                    'class' => 'btn btn-success'
                ]) ?>
            </div>
        </div>

    </div>
</form>
