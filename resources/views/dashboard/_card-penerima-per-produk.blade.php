<?php

use App\Http\Controllers\LayananController;

/* @see \App\Http\Controllers\DashboardController::index() */

$pivot = $pivotPenerimaProduk ?? null;
$rows = $pivot['rows'] ?? collect(); // penerima
$cols = $pivot['cols'] ?? collect(); // produk
$matrix = $pivot['matrix'] ?? [];

// Common categories (penerima) for each per-produk chart
$categoriesPenerima = [];
foreach ($rows as $r) { $categoriesPenerima[] = $r->nama; }

?>

<div class="card card-default">
  <div class="card-header">
    <h3 class="card-title">Penerima Manfaat per Jenis Produk</h3>
  </div>
  <div class="card-body">
    <?php if ($rows->isEmpty() || $cols->isEmpty()) { ?>
    <div class="text-muted">Belum ada data layanan untuk ditampilkan.</div>
    <?php } else { ?>
    <div class="mb-3">
      <div class="row">
        @foreach ($cols as $col)
          <div class="col-md-6 mb-3">
            <div class="border rounded p-2 h-100">
              <div class="font-weight-bold mb-1">{{ $col->nama }}</div>
              <canvas id="chart-penerima-per-produk-{{ $loop->index }}" style="width: 100%; height: 260px;"></canvas>
            </div>
          </div>
        @endforeach
      </div>
    </div>
    <div>
      <div class="table-responsive">
        <table class="table table-sm table-bordered mb-0">
          <thead class="thead-light">
          <tr>
            <th style="min-width:200px;">Jenis Produk</th>
            @foreach ($rows as $row)
              <th class="text-right">{{ $row->nama }}</th>
            @endforeach
          </tr>
          </thead>
          <tbody>
          @foreach ($cols as $col)
            <?php $ck = $col->id === null ? 'null' : (string) $col->id; ?>
            <tr>
              <td>{{ $col->nama }}</td>
              @foreach ($rows as $row)
                <?php
                  $rk = $row->id === null ? 'null' : (string) $row->id;
                  $val = (int) ($matrix[$rk][$ck] ?? 0);
                  $href = route(LayananController::ROUTE_INDEX, [
                    'id_ref_layanan_produk' => $col->id ?? 'null',
                    'id_ref_layanan_penerima_manfaat' => $row->id ?? 'null',
                  ]);
                ?>
                <td class="text-right"><a href="<?= $href; ?>">{{ number_format($val) }}</a></td>
              @endforeach
            </tr>
          @endforeach
          </tbody>
        </table>
      </div>
    </div>
    <?php } ?>
  </div>
</div>

@push('scripts')
  @if ($rows->isNotEmpty() && $cols->isNotEmpty())
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        const categories = @json($categoriesPenerima);
        function paletteColors(n) {
          const base = ['#106518', '#FF9900', '#990099', '#3366CC', '#FF9900'];
          const colors = [];
          for (let i = 0; i < n; i++) colors.push(base[i % base.length]);
          return colors;
        }
        @foreach ($cols as $col)
          (function(){
            const elId = 'chart-penerima-per-produk-{{ $loop->index }}';
            const data = [
              @foreach ($rows as $row)
                {{ (int) ($matrix[$row->id === null ? 'null' : (string) $row->id][$col->id === null ? 'null' : (string) $col->id] ?? 0) }},
              @endforeach
            ];
            const canvas = document.getElementById(elId);
            if (canvas) {
              new Chart(canvas, {
                type: 'bar',
                data: { labels: categories, datasets: [{ label: 'Jumlah', data, backgroundColor: paletteColors(data.length) }] },
                options: {
                  responsive: true,
                  plugins: {
                    legend: { display: false },
                    datalabels: {
                      anchor: 'end', align: 'end', color: '#111', clamp: true,
                      formatter: (v) => (v ?? 0).toLocaleString('id-ID'),
                      font: { weight: 'bold', size: 9 }
                    }
                  },
                  layout: { padding: { top: 16 } },
                  scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
                }
              });
            }
          })();
        @endforeach
      });
    </script>
  @endif
@endpush
