<?php

namespace App\Http\Controllers;

use App\Components\Session;
use App\Services\StandarPelayananExportService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;

class StandarPelayananController extends Controller implements HasMiddleware
{
    public const ROUTE_EXPORT_PDF = 'standar-pelayanan.export-pdf';


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
        $params = $request->query();

        if (Session::isInstansi()) {
            $params['id_instansi'] = Session::getIdInstansi();
        }

        $id_instansi = @$params['id_instansi'];

        if ($id_instansi == null) {
            return back()->with('danger', 'Silahkan pilih perangkat daerah terlebih dahulu');
        }

        return $this->exportService->stream($params);
    }
}
