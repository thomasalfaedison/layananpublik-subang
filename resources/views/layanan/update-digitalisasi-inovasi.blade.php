<?php

use App\Components\Html;
use App\Components\Session;

/* @see \App\Http\Controllers\LayananController::create() */
/* @see \App\Http\Controllers\LayananController::update() */
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

$listStatusDigitalisassi = [
    1 => 'Manual',
    2 => 'Semi Digital',
    3 => 'Full Online',
];

$listStatusInovasi = [
    1 => 'Ada',
    2 => 'Tidak Ada',
];

?>


@extends(LayoutConstant::MAIN_LAYOUT)

@section('title', 'Ubah Layanan')

@section('content')


    @include('layanan._card-nama-layanan',[
        'model' => $model
    ])


    <form action="{{ $action }}" method="POST">
        @csrf
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title">Form Layanan</h3>
            </div>

            <div class="card-body">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Terjadi kesalahan!</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <?= Form::label('status_digitalisasi', 'Status Digitalisasi') ?>
                            <?= Form::select('status_digitalisasi', $listStatusDigitalisassi, old('status_skm', $model->status_digitalisasi), [
                                'class' => 'form-control' . ($errors->has('status_digitalisasi') ? ' is-invalid' : ''),
                                'placeholder' => '- Pilih Status Digitalisasi -'
                            ]) ?>
                            @error('skm_status')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>



                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <?= Form::label('nama_aplikasi', 'Nama Aplikasi (Jika Semi Digital / Full Online)') ?>
                            <?= Form::text('nama_aplikasi', old('nama_aplikasi', $model->nama_aplikasi), [
                                'class' => 'form-control' . ($errors->has('nama_aplikasi') ? ' is-invalid' : ''),
                                'placeholder' => 'Nama Aplikasi',
                                'min' => 0,
                                'step' => '0.01'
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
                                <?= Form::label('link_aplikasi', 'Link Aplikasi (Jika Berbentuk Web)') ?>
                                <?= Form::text('link_aplikasi', old('nama_aplikasi', $model->link_aplikasi), [
                                'class' => 'form-control' . ($errors->has('link_aplikasi') ? ' is-invalid' : ''),
                                'placeholder' => 'Link Aplikasi',
                                'min' => 0,
                                'step' => '0.01'
                            ]) ?>

                            @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                                <?= Form::label('status_inovasi', 'Ada Inovasi?') ?>
                                <?= Form::select('status_inovasi', $listStatusInovasi, old('status_inovasi', $model->status_inovasi), [
                                'class' => 'form-control' . ($errors->has('status_inovasi') ? ' is-invalid' : ''),
                                'placeholder' => '- Pilih Status Inovasi -'
                            ]) ?>
                            @error('skm_status')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                                <?= Form::label('deskripsi_inovasi', 'Deskripsi Inovasi (Jika Ada)') ?>
                                <?= Form::textarea('deskripsi_inovasi', old('deskripsi_inovasi', $model->deskripsi_inovasi), [
                                'class' => 'form-control' . ($errors->has('deskripsi_inovasi') ? ' is-invalid' : ''),
                                'placeholder' => 'Deskripsi Aplikasi',
                                'rows' => 3
                            ]) ?>

                            @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <?= Form::hidden('id_instansi', old('id_instansi', $model->id_instansi)) ?>
                <?= Form::hidden('nama', old('nama', $model->nama)) ?>
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
@endsection