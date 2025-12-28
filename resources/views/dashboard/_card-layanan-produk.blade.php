@php
    $categories = ($produkChartCategories ?? collect())->values();
    $seriesData = ($produkChartData ?? collect())->values();
    $categoriesPenerima = ($penerimaChartCategories ?? collect())->values();
    $seriesDataPenerima = ($penerimaChartData ?? collect())->values();
@endphp

<div class="card card-default">
    <div class="card-header">
        <h3 class="card-title">Layanan per Produk</h3>
    </div>
    <div class="card-body">
        <?php if(($produkSummary ?? collect())->isEmpty()) { ?>
            <div class="text-muted">Belum ada data layanan untuk ditampilkan.</div>
        <?php } else { ?>
            <div class="row">
                <div class="col-md-7">
                    <div id="chart-layanan-produk" style="width: 100%; height: 360px;"></div>
                </div>
                <div class="col-md-5">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th style="width: 90px;">ID Produk</th>
                                    <th>Nama Produk</th>
                                    <th class="text-right" style="width: 100px;">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($produkSummary as $row)
                                    <tr>
                                        <td>{{ $row->id_ref_layanan_produk ?? '-' }}</td>
                                        <td>{{ $row->produk_nama }}</td>
                                        <td class="text-right">{{ number_format($row->jumlah_layanan) }}</td>
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
    @if (($produkSummary ?? collect())->isNotEmpty())
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Highcharts.chart('chart-layanan-produk', {
                    chart: { type: 'column' },
                    title: { text: 'Distribusi Layanan per Produk' },
                    xAxis: {
                        categories: @json($categories),
                        title: { text: 'Produk' },
                        labels: { style: { fontSize: '11px' } }
                    },
                    yAxis: {
                        min: 0,
                        allowDecimals: false,
                        title: { text: 'Jumlah Layanan' }
                    },
                    legend: { enabled: false },
                    tooltip: {
                        pointFormat: '<b>{point.y} layanan</b>'
                    },
                    series: [{
                        name: 'Jumlah',
                        data: @json($seriesData),
                        colorByPoint: true
                    }],
                    credits: { enabled: false }
                });
            });
        </script>
    @endif
@endpush
