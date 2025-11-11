@php
    use App\Http\Controllers\InstansiController;
    use App\Http\Controllers\LayananController;
    use App\Components\Helper;
    use App\Components\Session;
@endphp


<div class="card card-default">
    <div class="card-header">
        <h3 class="card-title">
            Rekap Data
        </h3>
    </div>
    <div class="card-body pb-0">
        <div class="row">
            @if (Session::isAdmin())    
                <div class="col-md-3">
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3>{{ Helper::rp($jumlahInstansi, 0) }}</h3>
                            <p>Jumlah Perangkat Daerah</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-building"></i>
                        </div>
                        <a href="{{ route(InstansiController::ROUTE_INDEX) }}" class="small-box-footer">
                            <i class="fa fa-arrow-circle-right"></i> Lihat Detail
                        </a>
                    </div>
                </div>
            @endif

            <div class="col-md-3">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ Helper::rp($jumlahLayanan, 0) }}</h3>
                        <p>Jumlah Layanan</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-clipboard-check"></i>
                    </div>
                    <a href="{{ route(LayananController::ROUTE_INDEX) }}" class="small-box-footer">
                        <i class="fa fa-arrow-circle-right"></i> Lihat Detail
                    </a>
                </div>

            </div>

        </div>
    </div>
</div>