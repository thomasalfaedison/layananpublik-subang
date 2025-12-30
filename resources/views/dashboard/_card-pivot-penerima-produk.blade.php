<?php

use App\Http\Controllers\LayananController;

/* @see \App\Http\Controllers\DashboardController::index() */

$pivot = $pivotPenerimaProduk ?? null;
$rows = $pivot['rows'] ?? collect();
$cols = $pivot['cols'] ?? collect();
$matrix = $pivot['matrix'] ?? [];
$rowTotals = $pivot['rowTotals'] ?? [];
$colTotals = $pivot['colTotals'] ?? [];
$grandTotal = $pivot['grandTotal'] ?? 0;

?>

<div class="card card-default">
  <div class="card-header">
    <h3 class="card-title">Tabel Layanan: Penerima Manfaat × Produk</h3>
  </div>
  <div class="card-body">
    <?php if (($rows->count() === 0) || ($cols->count() === 0)) { ?>
      <div class="text-muted">Belum ada data layanan untuk ditampilkan.</div>
    <?php } else { ?>
      <div class="table-responsive">
        <table class="table table-sm table-bordered mb-0">
          <thead class="thead-light">
          <tr>
            <th style="min-width:220px;">Penerima Manfaat</th>
            @foreach ($cols as $col)
              <th class="text-right">{{ $col->nama }}</th>
            @endforeach
            <th class="text-right" style="min-width:100px;">Total</th>
          </tr>
          </thead>
          <tbody>
          @foreach ($rows as $row)
            <?php $rowKey = $row->id === null ? 'null' : (string) $row->id; ?>
            <tr>
              <td>{{ $row->nama }}</td>
              @foreach ($cols as $col)
                <?php
                  $colKey = $col->id === null ? 'null' : (string) $col->id;
                  $val = $matrix[$rowKey][$colKey] ?? 0;
                  $hrefCell = route(LayananController::ROUTE_INDEX, [
                    'id_ref_layanan_penerima_manfaat' => $row->id ?? 'null',
                    'id_ref_layanan_produk' => $col->id ?? 'null',
                  ]);
                ?>
                <td class="text-right">
                  <a href="<?= $hrefCell; ?>">{{ number_format($val) }}</a>
                </td>
              @endforeach
              <?php $hrefRow = route(LayananController::ROUTE_INDEX, [
                  'id_ref_layanan_penerima_manfaat' => $row->id ?? 'null',
                ]); ?>
              <td class="text-right font-weight-bold">
                <a href="<?= $hrefRow; ?>">{{ number_format($rowTotals[$rowKey] ?? 0) }}</a>
              </td>
            </tr>
          @endforeach
          </tbody>
          <tfoot>
          <tr>
            <th>Total</th>
            @foreach ($cols as $col)
              <?php
                $ck = $col->id === null ? 'null' : (string) $col->id;
                $hrefCol = route(LayananController::ROUTE_INDEX, [
                    'id_ref_layanan_produk' => $col->id ?? 'null',
                ]);
              ?>
              <th class="text-right">
                <a href="<?= $hrefCol; ?>">{{ number_format($colTotals[$ck] ?? 0) }}</a>
              </th>
            @endforeach
            <th class="text-right">{{ number_format($grandTotal) }}</th>
          </tr>
          </tfoot>
        </table>
      </div>
    <?php } ?>
  </div>
</div>

