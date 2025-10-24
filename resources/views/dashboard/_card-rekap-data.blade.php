@php
    use App\Constants\InstansiConstant;
    use App\Components\Helper;
@endphp


<div class="card card-default">
    <div class="card-header">
        <h3 class="card-title">
            Rekap Data
        </h3>
    </div>
    <div class="card-body pb-0">
        <div class="row">
            <div class="col-md-3">
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3>{{ Helper::rp($jumlahInstansi, 0) }}</h3>
                        <p>Jumlah Perangkat Daerah</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-building"></i>
                    </div>
                    <a href="{{ route(InstansiConstant::RouteIndex) }}" class="small-box-footer">
                        <i class="fa fa-arrow-circle-right"></i> Lihat Detail
                    </a>
                </div>

            </div>

            <div class="col-md-3">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ Helper::rp($persenPengisian, 0, 2) }}</h3>
                        <p>Progres Pengisian</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-clipboard-check"></i>
                    </div>
                    <a href="{{ route(InstansiConstant::RouteIndexPengisian) }}" class="small-box-footer">
                        <i class="fa fa-arrow-circle-right"></i> Lihat Detail
                    </a>
                </div>

            </div>

            <div class="col-md-3">
                <div class="small-box bg-purple">
                    <div class="inner">
                        <h3>{{ Helper::rp($persenPenilaian, 0, 2) }}%</h3>
                        <p>Progres Penilaian</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-tasks"></i>
                    </div>
                    <a href="{{ route(InstansiConstant::RouteIndexPenilaian) }}" class="small-box-footer">
                        <i class="fa fa-arrow-circle-right"></i> Lihat Detail
                    </a>
                </div>

            </div>

            <div class="col-md-3">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ Helper::rp($nilaiPenilaian, 0, 2) }}</h3>
                        <p>Nilai Penilaian</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <a href="{{ route(InstansiConstant::RouteIndexPenilaian) }}" class="small-box-footer">
                        <i class="fa fa-arrow-circle-right"></i> Lihat Detail
                    </a>
                </div>

            </div>

        </div>
    </div>
</div>