<?php

namespace App\Http\Controllers;

use App\Services\StandarPelayananExportService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;

class StandarPelayananController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['auth'];
    }

    public function __construct(
        protected StandarPelayananExportService $exportService,
    ) {
    }

    public function exportPdf(Request $request)
    {
        $idInstansi = $request->query('id_instansi');

        return $this->exportService->stream($idInstansi);
    }
}
