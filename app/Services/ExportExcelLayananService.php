<?php

namespace App\Services;

use App\Components\Session;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ExportExcelLayananService
{
    public function __construct(
        protected LayananService $layananService,
    ) {
    }

    public function getData(array $params = [])
    {
        $queryParams = $params;

        if (Session::isInstansi()) {
            $queryParams['id_instansi'] = Session::getIdInstansi();
        }

        return $this->layananService->findAll($queryParams);
    }

    public function setTitle($sheet, bool $includeInstansi): void
    {
        $columns = $this->columns($includeInstansi);
        $lastColumn = $this->getLastColumnLetter($columns);

        $sheet->setCellValue('A1', 'Daftar Layanan');
        $sheet->mergeCells("A1:{$lastColumn}2");
    }

    public function setHeader($sheet, int $row, bool $includeInstansi): array
    {
        $columns = $this->columns($includeInstansi);
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

    public function applyColumnWidths($sheet, bool $includeInstansi): void
    {
        $columns = $this->columns($includeInstansi);

        foreach ($columns as $index => $column) {
            $columnLetter = Coordinate::stringFromColumnIndex($index + 1);

            $width = match ($column['key']) {
                'no' => 8,                     // approx 60px
                'nama' => 40,                  // wider for service name
                'instansi' => 50,              // align with ~400px in table
                'persen_kelengkapan' => 18,    // center metric
                default => 15,
            };

            $sheet->getColumnDimension($columnLetter)->setWidth($width);
        }
    }

    public function setBody($sheet, int $row, $allLayanan, bool $includeInstansi): int
    {
        $columns = $this->columns($includeInstansi);

        foreach ($allLayanan as $index => $layanan) {
            foreach ($columns as $columnIndex => $column) {
                $columnLetter = Coordinate::stringFromColumnIndex($columnIndex + 1);
                $value = $this->resolveCellValue($column['key'], $layanan, $index);

                $sheet->setCellValue($columnLetter . $row, $value);

                $sheet->getStyle($columnLetter . $row)->applyFromArray([
                    'alignment' => [
                        'horizontal' => $column['align'],
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

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

    protected function resolveCellValue(string $key, $layanan, int $index)
    {
        return match ($key) {
            'no' => $index + 1,
            'nama' => $layanan->nama,
            'instansi' => $layanan->instansi?->nama,
            'persen_kelengkapan' => $layanan->persen_komponen,
            default => '',
        };
    }

    protected function columns(bool $includeInstansi): array
    {
        $columns = [
            ['key' => 'no', 'label' => 'No', 'align' => Alignment::HORIZONTAL_CENTER],
            ['key' => 'nama', 'label' => 'Nama Layanan', 'align' => Alignment::HORIZONTAL_LEFT],
        ];

        if ($includeInstansi) {
            $columns[] = ['key' => 'instansi', 'label' => 'Perangkat Daerah', 'align' => Alignment::HORIZONTAL_LEFT];
        }

        $columns[] = ['key' => 'persen_kelengkapan', 'label' => 'Persen Kelengkapan', 'align' => Alignment::HORIZONTAL_CENTER];

        return $columns;
    }

    protected function getLastColumnLetter(array $columns): string
    {
        return Coordinate::stringFromColumnIndex(count($columns));
    }
}
