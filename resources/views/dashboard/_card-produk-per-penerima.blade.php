<?php

use App\Http\Controllers\LayananController;

/* @see \App\Http\Controllers\DashboardController::index() */

$pivot = $pivotPenerimaProduk ?? null;
$rows = $pivot['rows'] ?? collect(); // penerima
$cols = $pivot['cols'] ?? collect(); // produk
$matrix = $pivot['matrix'] ?? [];

// Common categories (produk) for each per-penerima chart
$categoriesProduk = [];
foreach ($cols as $c) { $categoriesProduk[] = $c->nama; }

?>

<div class="card card-default">
  <div class="card-header">
    <h3 class="card-title">Produk per Penerima Manfaat</h3>
  </div>
  <div class="card-body">
    <?php if ($rows->isEmpty() || $cols->isEmpty()) { ?>
      <div class="text-muted">Belum ada data layanan untuk ditampilkan.</div>
    <?php } else { ?>
      <div class="mb-3">
        <div class="row">
          @foreach ($rows as $row)
            <div class="col-md-6 mb-3">
              <div class="border rounded p-2 h-100">
                <div class="font-weight-bold mb-1">{{ $row->nama }}</div>
                <div id="chart-produk-per-penerima-{{ $loop->index }}" style="width: 100%; height: 260px;"></div>
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
              <th style="min-width:200px;">Penerima Manfaat</th>
              @foreach ($cols as $col)
                <th class="text-right">{{ $col->nama }}</th>
              @endforeach
            </tr>
            </thead>
            <tbody>
            @foreach ($rows as $row)
              <?php $rk = $row->id === null ? 'null' : (string) $row->id; ?>
              <tr>
                <td>{{ $row->nama }}</td>
                @foreach ($cols as $col)
                  <?php
                    $ck = $col->id === null ? 'null' : (string) $col->id;
                    $val = (int) ($matrix[$rk][$ck] ?? 0);
                    $href = route(LayananController::ROUTE_INDEX, [
                      'id_ref_layanan_penerima_manfaat' => $row->id ?? 'null',
                      'id_ref_layanan_produk' => $col->id ?? 'null',
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
        const categories = @json($categoriesProduk);
        @foreach ($rows as $row)
          (function(){
            const elId = 'chart-produk-per-penerima-{{ $loop->index }}';
            const data = [
              @foreach ($cols as $col)
                {{ (int) ($matrix[$row->id === null ? 'null' : (string) $row->id][$col->id === null ? 'null' : (string) $col->id] ?? 0) }},
              @endforeach
            ];
            if (document.getElementById(elId)) {
              Highcharts.chart(elId, {
                chart: { type: 'column' },
                title: { text: null },
                xAxis: { categories, labels: { style: { fontSize: '10px' } } },
                yAxis: { min: 0, allowDecimals: false, title: { text: null } },
                legend: { enabled: false },
                tooltip: { pointFormat: '<b>{point.y} layanan</b>' },
                series: [{ name: 'Jumlah', data }],
                credits: { enabled: false }
              });
            }
          })();
        @endforeach
      });
    </script>
  @endif
@endpush

