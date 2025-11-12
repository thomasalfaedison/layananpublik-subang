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

$listStatusSkm = [
    1 => 'Ya',
    0 => 'Tidak',
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
                            <?= Form::label('status_skm', 'Dilakukan SKM?') ?>
                            <?= Form::select('status_skm', $listStatusSkm, old('status_skm', $model->status_skm), [
                                'class' => 'form-control' . ($errors->has('skm_status') ? ' is-invalid' : ''),
                                'placeholder' => '- Pilih Status SKM -'
                            ]) ?>
                            @error('skm_status')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>



                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <?= Form::label('nilai_skm', 'Nilai SKM Terakhir') ?>
                            <?= Form::number('nilai_skm', old('nilai_skm', $model->nilai_skm), [
                                'class' => 'form-control' . ($errors->has('nilai_skm') ? ' is-invalid' : ''),
                                'placeholder' => 'Misal: 4,5',
                                'min' => 0,
                                'step' => '0.01'
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