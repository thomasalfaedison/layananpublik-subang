<?php

use App\Components\Html;
use App\Constants\SiteConstant;

?>

@extends(LayoutConstant::KUESIONER_LAYOUT)

@section('title', 'Terima Kasih')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-7 col-sm-12">

            <div class="card mb-4 shadow-sm">
                <div class="card-body text-center">
                    <h5 class="font-weight-bold mb-1">Sukses Mengisi Kuesioner</h5>
                    <p class="text-muted mb-0">Terima kasih, pengisian kuesioner <strong>{{ $kuesioner->nama }}</strong> telah berhasil.</p>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h3 class="card-title mb-0">Ringkasan Responden</h3>
                </div>
                <div class="card-body">
                    <div class="mb-3 text-center">
                        <i class="fas fa-check-circle fa-3x text-success"></i>
                    </div>

                    <div class="border rounded p-3 mb-3">
                        <div class="row">
                            <div class="col-sm-6">
                                <p class="mb-1"><strong>Kode Kuesioner:</strong> {{ $kuesioner->kode }}</p>
                                @if(isset($respondenData['kementerian_lembaga']))
                                    <p class="mb-1"><strong>Kementerian / Lembaga:</strong> {{ $respondenData['kementerian_lembaga'] }}</p>
                                @endif
                                @if(isset($respondenData['lokasi']))
                                    <p class="mb-1"><strong>Lokasi:</strong> {{ $respondenData['lokasi'] }}</p>
                                @endif
                            </div>
                            <div class="col-sm-6">
                                @if(isset($instansi->nama))
                                    <p class="mb-1"><strong>Unit Penyelenggara:</strong> {{ $instansi->nama }}</p>
                                @endif
                                @if(isset($respondenData['kabupaten_kota']))
                                    <p class="mb-1"><strong>Kabupaten / Kota:</strong> {{ $respondenData['kabupaten_kota'] }}</p>
                                @endif
                                @if(isset($respondenData['provinsi']))
                                    <p class="mb-1"><strong>Provinsi:</strong> {{ $respondenData['provinsi'] }}</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="text-center">
                        <a href="<?= url('/') ?>" class="btn btn-secondary mb-2">
                            <i class="fas fa-home mr-1"></i> Kembali ke Beranda
                        </a>
                        <a href="{{ route(SiteConstant::RouteKuesionerResponden, ['kode' => $kuesioner->kode]) }}" 
                        class="btn btn-primary mb-2 ml-2" 
                        data-toggle="tooltip" 
                        title="Kembali ke Pengisian Kuesioner">
                            <i class="fa fa-link mr-1"></i> Kembali ke Pengisian <?= $kuesioner->kode ?>
                        </a>
                    </div>

                    <p class="text-muted text-center mt-3 mb-0" style="font-size: 0.85rem;">
                        Kalau ada yang perlu dikoreksi, hubungi penyelenggara.
                    </p>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
