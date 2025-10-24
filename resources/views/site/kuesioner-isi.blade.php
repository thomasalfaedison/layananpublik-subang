<?php

use App\Components\Html;
use App\Constants\SiteConstant;
use App\Constants\KuesionerTipeConstant;

?>

@extends(LayoutConstant::KUESIONER_LAYOUT)

@section('title', 'Pengisian Kuesioner')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-7 col-sm-12">

            <div class="card mb-4 shadow-sm">
                <div class="card-body text-center">
                    <h5 class="font-weight-bold mb-0">
                        {{ $kuesioner->nama }} | {{ $kuesioner->kode }}
                    </h5>
                </div>
            </div>

            <div class="card mb-4 shadow-sm border-info">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-info-circle mr-1"></i> Petunjuk Singkat Pengisian Kuesioner
                    </h6>
                </div>
                <div class="card-body">

                    <div class="mb-3">
                        {!! $kuesioner->petunjuk !!}
                    </div>

                    @if (count($listInstansiKontak) > 0)    
                        <i class="font-weight-bold mt-3">Contact Person:</i>
                        <div class="table-responsive">
                            <table class="table table-sm table-borderless mb-0">
                                <thead>
                                    <tr>
                                        <th class="py-0 pr-2 text-center" style="width: 5%;">No</th>
                                        <th class="py-0 pr-2" style="width: 30%;">Nama</th>
                                        <th class="py-0 pr-2" style="width: 30%;">No HP</th>
                                        <th class="py-0 pr-2" style="width: 35%;">Email</th>
                                    </tr>
                                </thead>
                                @foreach ($listInstansiKontak as $instansiKontak)
                                    <tr>
                                        <td class="py-0 pr-2">{{ $loop->iteration }})</td>
                                        <td class="py-0 pr-2">{{ $instansiKontak->nama }}</td>
                                        <td class="py-0 pr-2">{{ $instansiKontak->no_hp }}</td>
                                        <td class="py-0 pr-2">{{ $instansiKontak->email }}</td>
                                    </tr>
                                @endforeach
                            </table>

                        </div>
                    @endif
                </div>
            </div>

            <form action="{{ route(SiteConstant::RouteKuesionerIsi, ['data' => request()->query('data')]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h6 class="mb-0">Formulir Kuesioner</h6>
                    </div>

                    <div class="card-body">
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($listKuesionerPertanyaanRecursive as $kuesionerPertanyaan)
                                @php
                                    $params = [
                                        'no' => $no++,
                                        'kuesionerPertanyaan' => $kuesionerPertanyaan,
                                        'level' => 0,
                                    ];
                                @endphp
                                @if ($kuesioner->id_kuesioner_tipe == KuesionerTipeConstant::MANDIRI)
                                    @include('site._div-pertanyaan-manual', $params)
                                @endif
                                @if ($kuesioner->id_kuesioner_tipe == KuesionerTipeConstant::PENGGUNA_LAYANAN)
                                    @include('site._div-pertanyaan-survei', $params)
                                @endif
                            @endforeach
                        </div>
                        <div class="card-footer text-right">
                            <?= Html::submit('<i class="fas fa-check mr-1"></i> Simpan', [
                                'class' => 'btn btn-primary'
                            ]) ?>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection

@push('styles')
    <style>
        ol {
            padding-left: 1.2rem !important;
        }

        ol ol {
            list-style-type: lower-alpha !important;
        }

        ol ol ol {
            list-style-type: lower-roman !important;
        }
    </style>

@endpush
