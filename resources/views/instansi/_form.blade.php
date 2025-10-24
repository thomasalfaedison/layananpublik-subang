<?php

use App\Components\Html;

/* @var $url string */
/* @var $referrer string */
/* @var $model \App\Models\Instansi */

?>

<form action="{{ $action }}" method="POST">
    @csrf
    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">Form Perangkat Daerah</h3>
        </div>

        <div class="card-body">

            <div class="form-group col-sm-6">
                <?= Form::label('tahun_awal', 'Tahun Awal', ['required' => true]) ?>
                <?= Form::text('tahun_awal', old('tahun_awal', $model->tahun_awal), [
                    'class' => 'form-control' . ($errors->has('tahun_awal') ? ' is-invalid' : ''),
                    'placeholder' => 'Masukkan tahun awal'
                ]) ?>
                @error('tahun_awal')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group col-sm-6">
                <?= Form::label('tahun_akhir', 'Tahun Akhir', ['required' => true]) ?>
                <?= Form::text('tahun_akhir', old('tahun_akhir', $model->tahun_akhir), [
                    'class' => 'form-control' . ($errors->has('tahun_akhir') ? ' is-invalid' : ''),
                    'placeholder' => 'Masukkan tahun akhir'
                ]) ?>
                @error('tahun_akhir')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group col-sm-6">
                <?= Form::label('nama', 'Nama PD', ['required' => true]) ?>
                <?= Form::text('nama', old('nama', $model->nama), [
                    'class' => 'form-control' . ($errors->has('nama') ? ' is-invalid' : ''),
                    'placeholder' => 'Nama Perangkat Daerah'
                ]) ?>
                @error('nama')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group col-sm-6">
                <?= Form::label('id_instansi_jenis', 'Jenis', ['required' => true]) ?>
                <?= Form::select('id_instansi_jenis', $listInstansiJenis,  old('id_instansi_jenis', $model->id_instansi_jenis), [
                    'class' => 'form-control' . ($errors->has('id_instansi_jenis') ? ' is-invalid' : ''),
                    'placeholder' => '- Pilih Jenis -'
                ]) ?>
                @error('id_instansi_jenis')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
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