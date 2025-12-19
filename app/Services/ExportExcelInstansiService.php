<?php

namespace App\Services;

use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ExportExcelInstansiService
{
    public function __construct(
        protected DashboardService $dashboardService,
    ) {
    }

    public function getData(): array
    {
        $allInstansi = $this->dashboardService->getAllInstansi();
        $instansiSummary = collect();

        if ($allInstansi->isNotEmpty()) {
            $instansiSummary = $this->dashboardService->getInstansiSummary($allInstansi->pluck('id')->all());

            $allInstansi = $allInstansi
                ->sortByDesc(function ($instansi) use ($instansiSummary) {
                    $summary = $instansiSummary->get($instansi->id);
                    return $summary->persen_kelengkapan ?? 0;
                })
                ->values();
        }

        return [$allInstansi, $instansiSummary];
    }

    public function setTitle($sheet): void
    {
        $columns = $this->columns();
        $lastColumn = $this->getLastColumnLetter($columns);

        $sheet->setCellValue('A1', 'Daftar Perangkat Daerah');
        $sheet->mergeCells("A1:{$lastColumn}2");
    }

    public function setHeader($sheet, int $row): array
    {
        $columns = $this->columns();
        $lastColumn = $this->getLastColumnLetter($columns);

        foreach ($columns as $index => $column) {
            $columnLetter = Coordinate::stringFromColumnIndex($index + 1);
            $sheet->setCellValue($columnLetter . $row, $column['label']);
        }

        $sheet->getStyle("A{$row}:{$lastColumn}{$row}")->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => '000000'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'D9D9D9'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        return [
            'row' => $row,
            'last_column' => $lastColumn,
        ];
    }

    public function setBody($sheet, int $row, Collection $allInstansi, Collection $instansiSummary): int
    {
        $columns = $this->columns();

        foreach ($allInstansi as $index => $instansi) {
            $summary = $instansiSummary->get($instansi->id);
            $jumlahLayanan = $summary->jumlah_layanan ?? 0;
            $persenKelengkapan = $summary->persen_kelengkapan ?? 0;

            foreach ($columns as $columnIndex => $column) {
                $columnLetter = Coordinate::stringFromColumnIndex($columnIndex + 1);
                $value = $this->resolveCellValue($column['key'], $instansi, $index, $jumlahLayanan, $persenKelengkapan);

                $sheet->setCellValue($columnLetter . $row, $value);

                $sheet->getStyle($columnLetter . $row)->applyFromArray([
                    'alignment' => [
                        'horizontal' => $column['align'],
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                if ($column['key'] === 'jumlah_layanan') {
                    $sheet->getStyle($columnLetter . $row)
                        ->getNumberFormat()
                        ->setFormatCode(NumberFormat::FORMAT_NUMBER);
                }

                if ($column['key'] === 'persen_kelengkapan') {
                    $sheet->getStyle($columnLetter . $row)
                        ->getNumberFormat()
                        ->setFormatCode('#,##0.00"%"');
                }
            }

            $row++;
        }

        return $row;
    }

    public function applyTableStyle($sheet, int $startRow, string $lastColumn, int $endRow): void
    {
        if ($endRow < $startRow) {
            return;
        }

        $sheet->getStyle(sprintf('A%d:%s%d', $startRow, $lastColumn, $endRow))->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ]);
    }

    protected function resolveCellValue(string $key, $instansi, int $index, $jumlahLayanan, $persenKelengkapan)
    {
        return match ($key) {
            'no' => $index + 1,
            'nama' => $instansi->nama,
            'jumlah_layanan' => $jumlahLayanan,
            'persen_kelengkapan' => $persenKelengkapan,
            default => '',
        };
    }

    protected function columns(): array
    {
        return [
            ['key' => 'no', 'label' => 'No', 'align' => Alignment::HORIZONTAL_CENTER],
            ['key' => 'nama', 'label' => 'Nama Perangkat Daerah', 'align' => Alignment::HORIZONTAL_LEFT],
            ['key' => 'jumlah_layanan', 'label' => 'Jumlah Layanan', 'align' => Alignment::HORIZONTAL_CENTER],
            ['key' => 'persen_kelengkapan', 'label' => '% Kelengkapan', 'align' => Alignment::HORIZONTAL_CENTER],
        ];
    }

    protected function getLastColumnLetter(array $columns): string
    {
        return Coordinate::stringFromColumnIndex(count($columns));
    }
}
