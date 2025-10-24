@php
    use App\Constants\InstansiConstant;
    use App\Components\Helper;
@endphp

@extends(LayoutConstant::MAIN_LAYOUT)

@section('title', 'Dashboard')

@section('content')

@include('dashboard._alert-pengisian', ['jadwalPengisianInfo' => $jadwalPengisianInfo])

<div class="card card-default">
    <div class="card-header">
        <h3 class="card-title">
            Rekap Data
        </h3>
    </div>
    <div class="card-body pb-0">
        <div class="row">
            <div class="col-md-3">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ Helper::rp($persenPengisian, 0, 2) }}%</h3>
                        <p>Progres Pengisian</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-clipboard-check"></i>
                    </div>
                    <a href="#" class="small-box-footer">
                        <i class="fa fa-arrow-circle-right"></i> Lihat Detail
                    </a>
                </div>

            </div>

            <div class="col-md-3">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ Helper::rp($nilaiPenilaian, 0, 2) }}</h3>
                        <p>Nilai</p>
                    </div>
                    <div class="icon">
                        <i class="fas fas fa-tasks"></i>
                    </div>
                    <a href="#" class="small-box-footer">
                        <i class="fa fa-arrow-circle-right"></i> Lihat Detail
                    </a>
                </div>

            </div>

        </div>
    </div>
</div>

@endsection
