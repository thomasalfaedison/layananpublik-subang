<?php

namespace App\Http\Controllers;

use App\Components\Session;
use App\Constants\LayananConstant;
use App\Services\ExportExcelInstansiService;
use App\Services\DashboardService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class DashboardController extends Controller implements HasMiddleware
{
    public const ROUTE_INDEX = 'dashboard.index';
    public const ROUTE_EXPORT_INSTANSI_EXCEL = 'dashboard.exportInstansiExcel';

    public static function middleware()
    {
        return ['auth'];
    }

    public function __construct(
        protected DashboardService $dashboardService,
        protected ExportExcelInstansiService $exportExcelInstansiService,
    ) {}

    public function index(Request $request)
    {
        $jumlahInstansi = $this->dashboardService->getJumlahInstansi();
        $jumlahLayanan = $this->dashboardService->getJumlahLayanan();
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

        return view('dashboard.index', [
            'jumlahInstansi' => $jumlahInstansi,
            'jumlahLayanan' => $jumlahLayanan,
            'allInstansi' => $allInstansi,
            'instansiSummary' => $instansiSummary,
        ]);
    }

    public function instansi(Request $request)
    {
        return redirect()->route(LayananConstant::RouteIndex);

        /*
        $params = $request->query();

        $id_instansi = Session::getIdInstansi();

        if ($id_instansi == null) {
            abort(403, 'Anda tidak memiliki akses ke dashboard instansi ini.');
        }

        $tahun = $params['tahun'] ?? Session::getTahun();

        return view('dashboard.instansi');
        */
    }

    public function exportInstansiExcel()
    {
        if (!Session::isAdmin()) {
            abort(403, 'Anda tidak memiliki akses ke fitur ini.');
        }

        [$allInstansi, $instansiSummary] = $this->exportExcelInstansiService->getData();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $this->exportExcelInstansiService->setTitle($sheet);

        $startRow = 3;
        $headerInfo = $this->exportExcelInstansiService->setHeader($sheet, $startRow);
        $row = $headerInfo['row'];
        $lastColumn = $headerInfo['last_column'];

        $row = $this->exportExcelInstansiService->setBody($sheet, $row + 1, $allInstansi, $instansiSummary);

        $this->exportExcelInstansiService->applyTableStyle($sheet, $startRow, $lastColumn, $row - 1);

        foreach (range('A', $lastColumn) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);

        $filename = 'daftar-perangkat-daerah.xlsx';

        $temp_file = tempnam(sys_get_temp_dir(), $filename);
        $writer->save($temp_file);

        return response()->download($temp_file, $filename)->deleteFileAfterSend(true);
    }
}
