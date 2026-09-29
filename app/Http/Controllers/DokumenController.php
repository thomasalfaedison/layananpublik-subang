<?php

namespace App\Http\Controllers;

use App\Components\Session;
use App\Models\Dokumen;
use App\Services\DokumenService;
use App\Services\InstansiService;
use App\Services\StandarPelayananService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\ValidationException;

class DokumenController extends Controller implements HasMiddleware
{
    public const ROUTE_VIEW = 'dokumen.view';
    public const ROUTE_UPLOAD_FORM = 'dokumen.uploadForm';
    public const ROUTE_UPLOAD = 'dokumen.upload';

    public static function middleware()
    {
        return ['auth'];
    }

    public function __construct(
        protected DokumenService $dokumenService,
        protected InstansiService $instansiService,
        protected StandarPelayananService $standarPelayananService,
    ) {
    }

    public function view(Request $request, string $slug)
    {
        $jenisDokumen = Dokumen::getJenisBySlug($slug);

        if ($jenisDokumen === null) {
            abort(404, 'Not Found');
        }

        $idInstansi = Session::isInstansi()
            ? Session::getIdInstansi()
            : (int) $request->query('id_instansi');

        if (empty($idInstansi)) {
            return back()->with('danger', 'Silahkan pilih perangkat daerah terlebih dahulu');
        }

        $berdasarkanTahun = in_array($jenisDokumen, [Dokumen::JENIS_BA, Dokumen::JENIS_MP], true);
        $tahun = null;

        if ($berdasarkanTahun) {
            $request->validate(['tahun' => 'nullable|integer|between:1901,2155']);
            $tahun = (int) ($request->query('tahun') ?: Session::getTahun());
        }

        $params = [
            'id_instansi' => $idInstansi,
            'jenis' => $jenisDokumen,
        ];

        if ($berdasarkanTahun) {
            $params['tahun'] = $tahun;
        }

        $dokumenModel = $this->dokumenService->findOne($params);

        if ($dokumenModel === null) {
            $dokumenModel = new Dokumen([
                'id_instansi' => $idInstansi,
                'jenis' => $jenisDokumen,
                ...($berdasarkanTahun ? ['tahun' => $tahun] : []),
            ]);

            $dokumenModel->setRelation('instansi', $this->instansiService->findById($idInstansi));
        }

        $standarPelayananModel = null;

        if ($jenisDokumen === Dokumen::JENIS_SP) {
            $standarPelayananModel = $this->standarPelayananService->firstOrCreate([
                'id_instansi' => $idInstansi,
            ]);
        }

        return view('dokumen.view', compact(
            'dokumenModel',
            'standarPelayananModel',
            'jenisDokumen',
            'slug',
            'tahun',
        ));
    }

    public function uploadForm(Request $request, string $slug)
    {
        $jenisDokumen = Dokumen::getJenisBySlug($slug);

        if ($jenisDokumen === null) {
            abort(404, 'Not Found');
        }

        $listInstansiDokumen = Session::isInstansi()
            ? []
            : $this->instansiService->getList();

        $tahun = null;

        if (in_array($jenisDokumen, [Dokumen::JENIS_BA, Dokumen::JENIS_MP], true)) {
            $request->validate(['tahun' => 'nullable|integer|between:1901,2155']);
            $tahun = (int) ($request->query('tahun') ?: Session::getTahun());
        }

        $referrer = URL::previous();

        return view('dokumen.upload', compact('jenisDokumen', 'slug', 'listInstansiDokumen', 'referrer', 'tahun'));
    }

    public function upload(Request $request, string $slug)
    {
        $jenisDokumen = Dokumen::getJenisBySlug($slug);

        if ($jenisDokumen === null) {
            abort(404, 'Not Found');
        }

        $referrer = $request->post('referrer', URL::previous());

        try {
            $data = $request->all();
            $data['jenis'] = $jenisDokumen;

            $this->dokumenService->upsert($data);

            if (in_array($jenisDokumen, [Dokumen::JENIS_BA, Dokumen::JENIS_MP], true)) {
                if (Session::isInstansi()) {
                    return redirect()->route(self::ROUTE_VIEW, [
                        'slug' => $slug,
                        'tahun' => $data['tahun'],
                    ])->with('success', 'Dokumen berhasil diupload');
                }

                $route = $jenisDokumen === Dokumen::JENIS_BA
                    ? InstansiController::ROUTE_INDEX_BERITA_ACARA
                    : InstansiController::ROUTE_INDEX_MAKLUMAT_PELAYANAN;

                return redirect()->route($route, ['tahun' => $data['tahun']])
                    ->with('success', 'Dokumen berhasil diupload');
            }

            return redirect($referrer)->with('success', 'Dokumen berhasil diupload');
        } catch (ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('danger', 'Data gagal disimpan. Silahkan periksa kembali isian Anda.');
        }
    }
}
