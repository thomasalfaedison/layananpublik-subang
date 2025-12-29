<?php

use App\Components\Html;
use App\Components\Session;

/* @see \App\Http\Controllers\LayananController::updateUcwords() */
/* @var $layanan \App\Models\Layanan */
/* @var $referrer string */
/* @var $action string */

?>


@extends(LayoutConstant::MAIN_LAYOUT)

@section('title', 'Ubah Layanan')

@section('content')

    @include('layanan._card-nama-layanan',[
        'model' => $layanan
    ])

    <form action="{{ $action }}" method="POST">
        @csrf
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title">Form Layanan</h3>
            </div>

            <div class="card-body">

                <?php if($errors->any()) { ?>
                    <div class="alert alert-danger">
                        <strong>Terjadi kesalahan!</strong>
                        <ul>
                            <?php foreach($errors->all() as $error) { ?>
                                <li>{{ $error }}</li>
                            <?php } ?>
                        </ul>
                    </div>
                <?php } ?>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <?= Form::label('nama', 'Nama Layanan UCWords') ?>
                            <?= Form::text('nama', old('nama', ucwords(strtolower($layanan->nama))), [
                                'class' => 'form-control' . ($errors->has('nama') ? ' is-invalid' : ''),
                                'placeholder' => 'Nama Layanan',
                            ]) ?>

                            @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <?= Form::hidden('id_instansi', old('id_instansi', $layanan->id_instansi)) ?>
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