<?php

use App\Components\Html;
use App\Components\Session;
use App\Constants\SiteConstant;
use App\Constants\KuesionerTipeConstant;

?>

@extends(LayoutConstant::KUESIONER_LAYOUT)

@section('title', 'Isian Data Responden')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-12">

            @php
                $displayInstansiName = $selectedInstansiName ?? ($id_instansi ? ($listInstansi[$id_instansi] ?? null) : null);
            @endphp

            <div class="card mb-4 shadow-sm">
                <div class="card-body text-center">
                    <h5 class="font-weight-bold mb-0">
                        {{ $kuesioner->nama }} | {{ $kuesioner->kode }}
                    </h5>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title mb-0">Informasi Responden</h3>
                </div>

                <div class="card-body">
                    <form action="{{ route(SiteConstant::RouteKuesionerResponden) }}" method="POST">
                        @csrf

                        <?= Form::hidden('kode', $kuesioner->kode) ?>

                        @if ($kuesioner->id_kuesioner_tipe == KuesionerTipeConstant::MANDIRI)
                            <div class="form-group">
                                <?= Form::label('kementerian_lembaga', 'Kementerian / Lembaga') ?>
                                <?= Form::text('kementerian_lembaga', old('kementerian_lembaga'), [
                                    'class' => 'form-control' . ($errors->has('kementerian_lembaga') ? ' is-invalid' : ''),
                                    'placeholder' => 'Masukkan Kementerian / Lembaga'
                                ]) ?>
                                @error('kementerian_lembaga')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <?= Form::label('id_instansi', 'Unit Penyelenggara') ?>

                                @if (Session::isInstansi())
                                    <?= Form::hidden('id_instansi', $id_instansi) ?>
                                    @if (!empty($instansiSingkatan))
                                        <?= Form::hidden('instansi', $instansiSingkatan) ?>
                                    @endif
                                    <?= Form::text('nama_instansi', $displayInstansiName, [
                                        'class' => 'form-control',
                                        'disabled' => true,
                                    ]) ?>
                                @else
                                    <?= Form::select('id_instansi', $listInstansi, old('id_instansi', $id_instansi), [
                                        'class' => 'form-control select2-field' . ($errors->has('id_instansi') ? ' is-invalid' : ''),
                                        'placeholder' => '- Pilih Unit Penyelanggara -'
                                    ]) ?>
                                @endif

                                @error('id_instansi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <?= Form::label('lokasi', 'Lokasi') ?>
                                <?= Form::text('lokasi', old('lokasi'), [
                                    'class' => 'form-control' . ($errors->has('lokasi') ? ' is-invalid' : ''),
                                    'placeholder' => 'Masukkan Lokasi'
                                ]) ?>
                                @error('lokasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        @endif

                        @if ($kuesioner->id_kuesioner_tipe == KuesionerTipeConstant::EVALUATOR)

                            <div class="form-group">
                                <?= Form::label('kabupaten_kota', 'Kabupaten / Kota') ?>
                                <?= Form::text('kabupaten_kota', old('kabupaten_kota'), [
                                    'class' => 'form-control' . ($errors->has('kabupaten_kota') ? ' is-invalid' : ''),
                                    'placeholder' => 'Masukkan Kabupaten / Kota'
                                ]) ?>
                                @error('kabupaten_kota')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <?= Form::label('provinsi', 'Provinsi') ?>
                                <?= Form::text('provinsi', old('provinsi'), [
                                    'class' => 'form-control' . ($errors->has('provinsi') ? ' is-invalid' : ''),
                                    'placeholder' => 'Masukkan Provinsi'
                                ]) ?>
                                @error('provinsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        @endif

                        @if ($kuesioner->id_kuesioner_tipe == KuesionerTipeConstant::PENGGUNA_LAYANAN)
                              <div class="form-group">
                                <?= Form::label('id_instansi', 'Unit Penyelenggara') ?>

                                @if (Session::isInstansi())
                                    <?= Form::hidden('id_instansi', $id_instansi) ?>
                                    @if (!empty($instansiSingkatan))
                                        <?= Form::hidden('instansi', $instansiSingkatan) ?>
                                    @endif
                                    <?= Form::text('nama_instansi', $displayInstansiName, [
                                        'class' => 'form-control',
                                        'disabled' => true,
                                    ]) ?>
                                @else
                                    <?= Form::select('id_instansi', $listInstansi, old('id_instansi', $id_instansi), [
                                        'class' => 'form-control select2-field' . ($errors->has('id_instansi') ? ' is-invalid' : ''),
                                        'placeholder' => '- Pilih Unit Penyelanggara -'
                                    ]) ?>
                                @endif

                                @error('id_instansi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <?= Form::label('nama_responden', 'Nama') ?>
                                <?= Form::text('nama_responden', old('nama_responden'), [
                                    'class' => 'form-control' . ($errors->has('nama_responden') ? ' is-invalid' : ''),
                                    'placeholder' => 'Masukkan Nama'
                                ]) ?>
                                @error('nama_responden')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <?= Form::label('umur', 'Umur') ?>
                                <?= Form::text('umur', old('umur'), [
                                    'class' => 'form-control' . ($errors->has('umur') ? ' is-invalid' : ''),
                                    'placeholder' => 'Masukkan Umur'
                                ]) ?>
                                @error('umur')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="d-block">Jenis Kelamin</label>

                                @foreach ($listRefJenisKelamin as $value => $label)
                                    <div class="form-check form-check-inline">
                                        <?= Form::radio(
                                            'id_jenis_kelamin',
                                            $value,
                                            old('id_jenis_kelamin') === $value,
                                            [
                                                'class' => 'form-check-input' . ($errors->has('id_jenis_kelamin') ? ' is-invalid' : ''),
                                                'id' => 'id_jenis_kelamin_' . strtolower($value)
                                            ]
                                        ) ?>
                                        <label class="form-check-label" for="id_jenis_kelamin_{{ strtolower($value) }}">
                                            {{ $label }}
                                        </label>
                                    </div>
                                @endforeach

                                @error('id_jenis_kelamin')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <?= Form::label('id_pendidikan', 'Pendidikan') ?>
                                <?= Form::select('id_pendidikan', $listRefPendidikan,  old('id_pendidikan'), [
                                    'class' => 'form-control' . ($errors->has('id_pendidikan') ? ' is-invalid' : ''),
                                    'placeholder' => '- Pilih Pendidikan -',
                                ]) ?>
                                @error('id_pendidikan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <?= Form::label('id_pekerjaan', 'Pekerjaan') ?>
                                <?= Form::select('id_pekerjaan', $listRefPekerjaan,  old('id_pekerjaan'), [
                                    'class' => 'form-control' . ($errors->has('id_pekerjaan') ? ' is-invalid' : ''),
                                    'placeholder' => '- Pilih Pekerjaan -',
                                ]) ?>
                                @error('id_pekerjaan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <?= Form::label('no_whatsapp', 'No WhatsApp') ?>
                                <?= Form::text('no_whatsapp', old('no_whatsapp'), [
                                    'class' => 'form-control' . ($errors->has('no_whatsapp') ? ' is-invalid' : ''),
                                    'placeholder' => 'Masukkan No WhatsApp'
                                ]) ?>
                                @error('no_whatsapp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        @endif

                        <div class="text-right mt-4">
                            <?= Html::submit('<i class="fas fa-arrow-right mr-1"></i> Selanjutnya', [
                                'class' => 'btn btn-primary'
                            ]) ?>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
