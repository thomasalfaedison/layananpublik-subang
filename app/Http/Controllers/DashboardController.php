<?php

namespace App\Http\Controllers;

use App\Components\Session;
use App\Constants\DashboardConstant;
use App\Constants\LayananConstant;
use App\Services\DashboardService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;

class DashboardController extends Controller implements HasMiddleware
{
    public const ROUTE_INDEX = 'dashboard.index';

    public static function middleware()
    {
        return ['auth'];
    }

    public function __construct(
        protected DashboardService $dashboardService,
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
}
