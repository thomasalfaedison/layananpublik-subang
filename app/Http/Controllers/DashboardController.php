<?php

namespace App\Http\Controllers;

use App\Components\Session;
use App\Constants\DashboardConstant;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;

class DashboardController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['auth'];
    }

    public function index(Request $request)
    {
        $params = $request->query();

        if (Session::isInstansi()) {
            return redirect(route(DashboardConstant::RouteInstansi));
        }

        return view('dashboard.index');
    }

    public function instansi(Request $request)
    {
        $params = $request->query();

        $id_instansi = Session::getIdInstansi();

        if ($id_instansi == null) {
            abort(403, 'Anda tidak memiliki akses ke dashboard instansi ini.');
        }

        $tahun = $params['tahun'] ?? Session::getTahun();

        return view('dashboard.instansi');
    }
}
