<?php

namespace App\Services;

use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ExportExcelUserService
{
    public function __construct(
        protected UserService $userService,
    ) {}

    public function getTitle($sheet, array $params, $listRole)
    {
        $idRole = $params['id_role'] ?? null;

        $title = 'Daftar User';

        if ($idRole !== null) {
            $roleName = $listRole[$idRole] ?? '';
            $title .= $roleName ? ' Role ' . $roleName : '';
        }

        $columns = $this->resolveColumns($idRole);
        $lastColumn = $this->getLastColumnLetter($columns);

        $sheet->setCellValue('A1', $title);
        $sheet->mergeCells("A1:{$lastColumn}2");
    }

    public function getHeader($sheet, $row, array $params): array
    {
        $idRole = $params['id_role'] ?? null;
        $columns = $this->resolveColumns($idRole);
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

    public function getBody($sheet, $row, array $params): int
    {
        $idRole = $params['id_role'] ?? null;
        $username = $params['username'] ?? null;
        $nama = $params['nama'] ?? null;

        $columns = $this->resolveColumns($idRole);

        $listUser = $this->userService->findAll([
            'username' => $username,
            'nama' => $nama,
            'id_role' => $idRole,
        ]);

        foreach ($listUser as $index => $user) {
            foreach ($columns as $columnIndex => $column) {
                $columnLetter = Coordinate::stringFromColumnIndex($columnIndex + 1);
                $value = $this->resolveCellValue($column['key'], $user, $index);

                $sheet->setCellValue($columnLetter . $row, $value);

                $sheet->getStyle($columnLetter . $row)->applyFromArray([
                    'alignment' => [
                        'horizontal' => $column['key'] === 'no'
                            ? Alignment::HORIZONTAL_CENTER
                            : Alignment::HORIZONTAL_LEFT,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);
            }

            $row++;
        }

        return $row;
    }

    private function resolveColumns(?int $idRole): array
    {
        $columns = [
            'no' => 'No',
            'username' => 'Username',
            'instansi' => 'Nama Instansi',
            'nama' => 'Nama',
        ];

        $order = match ($idRole) {
            1 => ['no', 'username'],
            2 => ['no', 'username', 'instansi'],
            3 => ['no', 'username', 'nama'],
            default => array_keys($columns),
        };

        return array_map(fn ($key) => ['key' => $key, 'label' => $columns[$key]], $order);
    }

    private function getLastColumnLetter(array $columns): string
    {
        return Coordinate::stringFromColumnIndex(count($columns));
    }

    private function resolveCellValue(string $columnKey, $user, int $index)
    {
        return match ($columnKey) {
            'no' => $index + 1,
            'username' => $user->username,
            'instansi' => $user->instansi?->nama,
            'nama' => $user->nama,
            default => null,
        };
    }
}

