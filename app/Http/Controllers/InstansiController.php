<?php

namespace App\Http\Controllers;

use App\Components\Session;
use App\Models\Instansi;
use App\Services\InstansiJenisService;
use App\Services\InstansiService;
use App\Services\StandarPelayananService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\ValidationException;

class InstansiController extends Controller implements HasMiddleware
{
    public const ROUTE_INDEX = 'instansi.index';
    public const ROUTE_INDEX_STANDAR_PELAYANAN = 'instansi.indexStandarPelayanan';
    public const ROUTE_INDEX_BERITA_ACARA = 'instansi.indexBeritaAcara';
    public const ROUTE_INDEX_MAKLUMAT_PELAYANAN = 'instansi.indexMaklumatPelayanan';

    public static function middleware()
    {
        return ['auth'];
    }

    public function __construct(
        protected InstansiService $instansiService,
        protected InstansiJenisService $instansiJenisService,
        protected StandarPelayananService $standarPelayananService,
    ) {}

    public function index(Request $request)
    {
        $params = $request->query();

        $allInstansi = $this->instansiService->paginate($params);

        return view('instansi.index',compact('allInstansi'));
    }

    public function indexStandarPelayanan(Request $request)
    {
        if (Session::isInstansi()) {
            return redirect()->route(DokumenController::ROUTE_VIEW, [
                'slug' => \App\Models\Dokumen::SLUG_STANDAR_PELAYANAN,
            ]);
        }

        return $this->renderDokumenIndex($request, \App\Models\Dokumen::JENIS_SP, 'instansi.index-standar-pelayanan');
    }

    public function indexBeritaAcara(Request $request)
    {
        if (Session::isInstansi()) {
            return redirect()->route(DokumenController::ROUTE_VIEW, [
                'slug' => \App\Models\Dokumen::SLUG_BERITA_ACARA,
            ]);
        }

        return $this->renderDokumenIndex($request, \App\Models\Dokumen::JENIS_BA, 'instansi.index-berita-acara');
    }

    public function indexMaklumatPelayanan(Request $request)
    {
        if (Session::isInstansi()) {
            return redirect()->route(DokumenController::ROUTE_VIEW, [
                'slug' => \App\Models\Dokumen::SLUG_MAKLUMAT_PELAYANAN,
            ]);
        }

        return $this->renderDokumenIndex($request, \App\Models\Dokumen::JENIS_MP, 'instansi.index-maklumat-pelayanan');
    }

    protected function renderDokumenIndex(Request $request, string $jenisDokumen, string $view)
    {
        $params = $request->query();

        if (Session::isInstansi()) {
            $params['id'] = Session::getIdInstansi();
        }

        $allInstansi = $this->instansiService->paginate($params);

        $dokumenByInstansi = app(\App\Services\DokumenService::class)->findAll([
            'id_instansi' => $allInstansi->pluck('id')->all(),
            'jenis' => $jenisDokumen,
        ])->keyBy('id_instansi');

        $allInstansi->getCollection()->transform(function (Instansi $instansi) use ($dokumenByInstansi) {
            $standarPelayanan = $this->standarPelayananService->firstOrCreate([
                'id_instansi' => $instansi->id,
            ]);

            $instansi->setRelation('standarPelayanan', $standarPelayanan);
            $instansi->setRelation('dokumenItem', $dokumenByInstansi->get($instansi->id));

            return $instansi;
        });

        return view($view, compact('allInstansi', 'jenisDokumen'));
    }

    public function create(Request $request)
    {
        $model = new Instansi();

        $referrer = URL::previous();

        if ($request->isMethod('post'))
        {
            try {
                $referrer = $request->post('referrer');
                $model = $this->instansiService->create($request->all());

                return redirect($referrer)->with('success', 'Perangkat Daerah berhasil dibuat');
            } catch (ValidationException $e) {
                return redirect()->back()
                    ->withErrors($e->validator)
                    ->withInput()
                    ->with('danger', 'Data gagal disimpan. Silahkan periksa kembali isian Anda.');
            }
        }

        $listInstansiJenis = $this->instansiJenisService->getList();

        return view('instansi.create',compact('model','referrer', 'listInstansiJenis'));
    }

    public function update(Request $request)
    {
        $id = $request->get('id');

        $model = $this->instansiService->findById($id);
        $referrer = URL::previous();

        if ($request->isMethod('post'))
        {
            try {
                $referrer = $request->post('referrer');
                $model = $this->instansiService->update($model, $request->all());

                return redirect($referrer)->with('success', 'Perangkat Daerah berhasil diupdate');
            } catch (ValidationException $e) {
                return redirect()->back()
                    ->withErrors($e->validator)
                    ->withInput()
                    ->with('danger', 'Data gagal disimpan. Silahkan periksa kembali isian Anda.');
            }
        }

        $listInstansiJenis = $this->instansiJenisService->getList();

        return view('instansi.update',compact('model','referrer', 'listInstansiJenis'));
    }

    public function read(Request $request)
    {
        $id = $request->get('id');

        $model = $this->instansiService->findById($id);

        if ($model == null)
        {
            return abort('404','Not Found');
        }

        return view('instansi.read',compact('model'));
    }

    public function delete(Request $request)
    {
        $id = $request->get('id');

        $model = $this->instansiService->findById($id);

        if ($model == null)
        {
            return abort('404','Not Found');
        }

        try {
            $this->instansiService->delete($model);
            return redirect()->back()->with('success', 'Perangkat Daerah berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('danger', 'Data gagal dihapus. Silahkan periksa kembali isian Anda.');
        }
    }
}
