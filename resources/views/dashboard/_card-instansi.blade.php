@php
    use App\Components\Helper;
    use App\Components\Html;
    use App\Http\Controllers\DashboardController;
    use App\Constants\LayananConstant;

    /**
     * @var \Illuminate\Support\Collection<\App\Models\Instansi> $allInstansi
     * @var \Illuminate\Support\Collection<int, \Illuminate\Database\Eloquent\Model> $instansiSummary
     **/
@endphp

<div class="card card-default">
    <div class="card-header">
        <h3 class="card-title">
            Daftar Perangkat Daerah
        </h3>
    </div>
    <div class="card-body">
        <div style="margin-bottom: 20px">
            <?= Html::a('<i class="fa fa-file-excel"></i> Export Excel', route(DashboardController::ROUTE_EXPORT_INSTANSI_EXCEL), [
                'class' => 'btn btn-success',
            ]) ?>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th style="width: 60px; text-align: center;">No</th>
                    <th>Nama Perangkat Daerah</th>
                    <th style="width: 150px; text-align: center;">Jumlah Layanan</th>
                    <th style="width: 150px; text-align: center;">% Kelengkapan</th>
                </tr>
            </thead>
            @foreach ($allInstansi as $instansi)
                @php
                    $summary = $instansiSummary->get($instansi->id);
                    $jumlahLayanan = $summary->jumlah_layanan ?? 0;
                    $persenKelengkapan = $summary->persen_kelengkapan ?? 0;
                @endphp
                <tr>
                    <td style="text-align: center;">
                        {{ $loop->iteration }}
                    </td>
                    <td>
                        {{ $instansi->nama }}
                    </td>
                    <td style="text-align: center">
                        <?= Html::a(
                            Helper::rp($jumlahLayanan, 0),
                            route(LayananConstant::RouteIndex, ['id_instansi' => $instansi->id]),
                            ['title' => 'Lihat layanan instansi ini']
                        ) ?>
                    </td>
                    <td style="text-align: center">
                        <?= Helper::rp($persenKelengkapan, 0, 2) ?>%
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
</div>
