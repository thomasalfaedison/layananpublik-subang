<?php

use App\Http\Controllers\LayananController;

/* @see \App\Http\Controllers\DashboardController::index() */

$categories = ($produkChartCategories ?? collect())->values();
$seriesData = ($produkChartData ?? collect())->values();
$categoriesPenerima = ($penerimaChartCategories ?? collect())->values();
$seriesDataPenerima = ($penerimaChartData ?? collect())->values();

?>

<div class="card card-default">
    <div class="card-header">
        <h3 class="card-title">Layanan per Penerima Manfaat</h3>
    </div>
    <div class="card-body">
        <?php if (($penerimaSummary ?? collect())->isEmpty()) { ?>
        <div class="text-muted">Belum ada data layanan untuk ditampilkan.</div>
        <?php } else { ?>
        <div class="row">
            <div class="col-md-7">
                <div id="chart-layanan-penerima" style="width: 100%; height: 360px;"></div>
            </div>
            <div class="col-md-5">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered mb-0">
                        <thead class="thead-light">
                        <tr>
                            <th style="width: 90px;">ID Penerima</th>
                            <th>Nama Penerima</th>
                            <th class="text-right" style="width: 100px;">Jumlah</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($penerimaSummary as $row)
                            <?php $href = route(LayananController::ROUTE_INDEX, [
                                'id_ref_layanan_penerima_manfaat' => $row->id_ref_layanan_penerima_manfaat ?? 'null'
                            ]); ?>
                            <tr>
                                <td>{{ $row->id_ref_layanan_penerima_manfaat ?? '-' }}</td>
                                <td>{{ $row->penerima_nama }}</td>
                                <td class="text-right">
                                    <a href="<?= $href; ?>">{{ number_format($row->jumlah_layanan) }}</a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>

@push('scripts')
    @if (($penerimaSummary ?? collect())->isNotEmpty())
        <script>
          document.addEventListener('DOMContentLoaded', function () {
            Highcharts.chart('chart-layanan-penerima', {
              chart: {type: 'column'},
              title: {text: 'Distribusi Layanan per Penerima Manfaat'},
              xAxis: {
                categories: @json($categoriesPenerima),
                title: {text: 'Penerima Manfaat'},
                labels: {style: {fontSize: '11px'}}
              },
              yAxis: {
                min: 0,
                allowDecimals: false,
                title: {text: 'Jumlah Layanan'}
              },
              legend: {enabled: false},
              tooltip: {
                pointFormat: '<b>{point.y} layanan</b>'
              },
              series: [{
                name: 'Jumlah',
                data: @json($seriesDataPenerima),
                colorByPoint: true
              }],
              credits: {enabled: false}
            });
          });
        </script>
    @endif
@endpush
