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
                <canvas id="chart-layanan-penerima" style="width: 100%; height: 360px;"></canvas>
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
            function paletteColors(n) {
              const base = ['#106518', '#FF9900', '#990099', '#3366CC', '#FF9900'];
              const colors = [];
              for (let i = 0; i < n; i++) colors.push(base[i % base.length]);
              return colors;
            }
            const ctx = document.getElementById('chart-layanan-penerima');
            if (!ctx) return;
            new Chart(ctx, {
              type: 'bar',
              data: {
                labels: @json($categoriesPenerima),
                datasets: [{ label: 'Jumlah', data: @json($seriesDataPenerima), backgroundColor: paletteColors(@json($seriesDataPenerima).length) }]
              },
              options: {
                responsive: true,
                plugins: { legend: { display: false }, title: { display: true, text: 'Distribusi Layanan per Penerima Manfaat' } },
                scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
              }
            });
          });
        </script>
    @endif
@endpush
