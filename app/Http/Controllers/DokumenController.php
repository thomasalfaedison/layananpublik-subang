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

        $dokumenModel = $this->dokumenService->findOne([
            'id_instansi' => $idInstansi,
            'jenis' => $jenisDokumen,
        ]);

        if ($dokumenModel === null) {
            $dokumenModel = new Dokumen([
                'id_instansi' => $idInstansi,
                'jenis' => $jenisDokumen,
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

        $referrer = URL::previous();

        return view('dokumen.upload', compact('jenisDokumen', 'slug', 'listInstansiDokumen', 'referrer'));
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

            return redirect($referrer)->with('success', 'Dokumen berhasil diupload');
        } catch (ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('danger', 'Data gagal disimpan. Silahkan periksa kembali isian Anda.');
        }
    }
}
