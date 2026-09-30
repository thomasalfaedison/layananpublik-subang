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
    public const ROUTE_INDEX_STANDAR_PELAYANAN = 'dokumen.indexStandarPelayanan';
    public const ROUTE_INDEX_BERITA_ACARA = 'dokumen.indexBeritaAcara';
    public const ROUTE_INDEX_MAKLUMAT_PELAYANAN = 'dokumen.indexMaklumatPelayanan';
    public const ROUTE_UPLOAD_FORM = 'dokumen.uploadForm';
    public const ROUTE_UPLOAD = 'dokumen.upload';
    public const ROUTE_UPDATE = 'dokumen.update';
    public const ROUTE_UPDATE_PROCESS = 'dokumen.updateProcess';
    public const ROUTE_DELETE = 'dokumen.delete';

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

    public function indexStandarPelayanan()
    {
        if (!Session::isInstansi()) {
            return redirect()->route(InstansiController::ROUTE_INDEX_STANDAR_PELAYANAN);
        }

        $idInstansi = Session::getIdInstansi();
        $allDokumen = Dokumen::query()
            ->where('id_instansi', $idInstansi)
            ->where('jenis', Dokumen::JENIS_SP)
            ->orderByDesc('tahun')
            ->orderByDesc('tanggal')
            ->orderByDesc('id')
            ->paginate(10);
        return view('dokumen.index-standar-pelayanan', compact('allDokumen'));
    }

    public function indexBeritaAcara()
    {
        if (!Session::isInstansi()) {
            return redirect()->route(InstansiController::ROUTE_INDEX_BERITA_ACARA);
        }

        $allDokumen = Dokumen::query()
            ->where('id_instansi', Session::getIdInstansi())
            ->where('jenis', Dokumen::JENIS_BA)
            ->orderByDesc('tahun')
            ->paginate(10);

        return view('dokumen.index-berita-acara', compact('allDokumen'));
    }

    public function indexMaklumatPelayanan()
    {
        if (!Session::isInstansi()) {
            return redirect()->route(InstansiController::ROUTE_INDEX_MAKLUMAT_PELAYANAN);
        }

        $allDokumen = Dokumen::query()
            ->where('id_instansi', Session::getIdInstansi())
            ->where('jenis', Dokumen::JENIS_MP)
            ->orderByDesc('tahun')
            ->paginate(10);

        return view('dokumen.index-maklumat-pelayanan', compact('allDokumen'));
    }

    public function view(Request $request, string $slug)
    {
        $jenisDokumen = Dokumen::getJenisBySlug($slug);

        if ($jenisDokumen === null) {
            abort(404, 'Not Found');
        }

        if ($jenisDokumen === Dokumen::JENIS_BA && Session::isInstansi()) {
            return redirect()->route(self::ROUTE_INDEX_BERITA_ACARA);
        }

        if ($jenisDokumen === Dokumen::JENIS_MP && Session::isInstansi()) {
            return redirect()->route(self::ROUTE_INDEX_MAKLUMAT_PELAYANAN);
        }

        if ($jenisDokumen === Dokumen::JENIS_SP) {
            return redirect()->route(Session::isInstansi()
                ? self::ROUTE_INDEX_STANDAR_PELAYANAN
                : InstansiController::ROUTE_INDEX_STANDAR_PELAYANAN);
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

        if (in_array($jenisDokumen, [Dokumen::JENIS_SP, Dokumen::JENIS_BA, Dokumen::JENIS_MP], true)) {
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
                    if ($jenisDokumen === Dokumen::JENIS_BA) {
                        return redirect()->route(self::ROUTE_INDEX_BERITA_ACARA)
                            ->with('success', 'Dokumen berhasil diupload');
                    }

                    return redirect()->route(self::ROUTE_INDEX_MAKLUMAT_PELAYANAN)
                        ->with('success', 'Dokumen berhasil diupload');
                }

                $route = $jenisDokumen === Dokumen::JENIS_BA
                    ? InstansiController::ROUTE_INDEX_BERITA_ACARA
                    : InstansiController::ROUTE_INDEX_MAKLUMAT_PELAYANAN;

                return redirect()->route($route, ['tahun' => $data['tahun']])
                    ->with('success', 'Dokumen berhasil diupload');
            }

            if ($jenisDokumen === Dokumen::JENIS_SP && Session::isInstansi()) {
                return redirect()->route(self::ROUTE_INDEX_STANDAR_PELAYANAN)
                    ->with('success', 'Dokumen berhasil diupload');
            }

            if ($jenisDokumen === Dokumen::JENIS_SP) {
                return redirect()->route(InstansiController::ROUTE_INDEX_STANDAR_PELAYANAN, [
                    'tahun' => $data['tahun'],
                ])->with('success', 'Dokumen berhasil diupload');
            }

            return redirect($referrer)->with('success', 'Dokumen berhasil diupload');
        } catch (ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('danger', 'Data gagal disimpan. Silahkan periksa kembali isian Anda.');
        }
    }

    public function update(Request $request)
    {
        $dokumenModel = $this->manageableDokumen($request);
        $referrer = $this->indexRouteFor($dokumenModel, $dokumenModel->tahun);

        if ($request->isMethod('post')) {
            try {
                $this->dokumenService->update($dokumenModel, $request->all());

                return redirect($this->indexRouteFor($dokumenModel, $dokumenModel->tahun))
                    ->with('success', 'Dokumen berhasil diperbarui');
            } catch (ValidationException $e) {
                return redirect()->back()
                    ->withErrors($e->validator)
                    ->withInput()
                    ->with('danger', 'Data gagal disimpan. Silahkan periksa kembali isian Anda.');
            }
        }

        return view('dokumen.update', compact('dokumenModel', 'referrer'));
    }

    public function delete(Request $request)
    {
        $dokumenModel = $this->manageableDokumen($request);
        $redirect = $this->indexRouteFor($dokumenModel, $dokumenModel->tahun);

        try {
            if (!$this->dokumenService->delete($dokumenModel)) {
                return redirect($redirect)->with('danger', 'Dokumen gagal dihapus');
            }

            return redirect($redirect)->with('success', 'Dokumen berhasil dihapus');
        } catch (\Exception $e) {
            return redirect($redirect)->with('danger', 'Dokumen gagal dihapus');
        }
    }

    protected function manageableDokumen(Request $request): Dokumen
    {
        if (!Session::isAdmin() && !Session::isInstansi()) {
            abort(403);
        }

        $query = Dokumen::query()
            ->whereKey((int) $request->get('id'))
            ->whereIn('jenis', [Dokumen::JENIS_SP, Dokumen::JENIS_BA, Dokumen::JENIS_MP]);

        if (Session::isInstansi()) {
            $query->where('id_instansi', Session::getIdInstansi());
        }

        return $query->firstOrFail();
    }

    protected function indexRouteFor(Dokumen $model, ?int $tahun): string
    {
        if (Session::isInstansi()) {
            return route(match ($model->jenis) {
                Dokumen::JENIS_SP => self::ROUTE_INDEX_STANDAR_PELAYANAN,
                Dokumen::JENIS_BA => self::ROUTE_INDEX_BERITA_ACARA,
                Dokumen::JENIS_MP => self::ROUTE_INDEX_MAKLUMAT_PELAYANAN,
            });
        }

        if ($model->jenis === Dokumen::JENIS_SP) {
            return route(InstansiController::ROUTE_INDEX_STANDAR_PELAYANAN, ['tahun' => $tahun]);
        }

        return route($model->jenis === Dokumen::JENIS_BA
            ? InstansiController::ROUTE_INDEX_BERITA_ACARA
            : InstansiController::ROUTE_INDEX_MAKLUMAT_PELAYANAN, ['tahun' => $tahun]);
    }
}
