<?php

namespace App\Http\Controllers;

use App\Components\Session;
use App\Models\Layanan;
use App\Models\RefLayananKomponen;
use App\Services\InstansiService;
use App\Services\LayananKomponenService;
use App\Services\LayananService;
use App\Services\RefAtributBiayaService;
use App\Services\RefAtributSiklusLayananService;
use App\Services\RefAtributSkmService;
use App\Services\RefAtributSopService;
use App\Services\RefLayananKomponenService;
use App\Services\RefLayananPemicuService;
use App\Services\RefLayananPenerimaManfaatService;
use App\Services\RefLayananProdukService;
use App\Services\RefLayananTeknisService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\ValidationException;

class LayananController extends Controller implements HasMiddleware
{
    public const ROUTE_INDEX = 'layanan.index';
    public const RouteView = 'layanan.view';

    public static function middleware()
    {
        return ['auth'];
    }

    public function __construct(
        protected LayananService $layananService,
        protected InstansiService $instansiService,
        protected RefLayananPemicuService $refLayananPemicuService,
        protected RefLayananTeknisService $refLayananTeknisService,
        protected RefLayananPenerimaManfaatService $refLayananPenerimaManfaatService,
        protected RefLayananProdukService $refLayananProdukService,
        protected RefAtributBiayaService $refAtributBiayaService,
        protected RefAtributSopService $refAtributSopService,
        protected RefAtributSiklusLayananService $refAtributSiklusLayananService,
        protected RefAtributSkmService $refAtributSkmService,
        protected RefLayananKomponenService $refLayananKomponenService,
        protected LayananKomponenService $layananKomponenService,
    ) {
    }

    public function index(Request $request)
    {
        $params = $request->query();

        if (Session::isInstansi()) {
            $params['id_instansi'] = Session::getIdInstansi();
        }

        $allLayanan = $this->layananService->paginate($params);

        $listInstansi = $this->instansiService->getList();

        return view('layanan.index', compact(
            'allLayanan',
            'listInstansi',
        ));
    }

    public function create(Request $request)
    {
        $model = new Layanan();
        $referrer = URL::previous();

        if ($request->isMethod('post')) {
            try {
                $data = $this->normalizeBooleanFields($request->all());
                $referrer = $request->post('referrer', $referrer);

                $model = $this->layananService->create($data);

                return redirect(route(self::RouteView,[
                    'id' => $model->id,
                ]))->with('success', 'Layanan berhasil dibuat');

            } catch (ValidationException $e) {
                return redirect()->back()
                    ->withErrors($e->validator)
                    ->withInput()
                    ->with('danger', 'Data gagal disimpan. Silakan periksa kembali isian Anda.');
            }
        }

        return view('layanan.create', $this->getFormData(compact('model', 'referrer')));
    }

    public function update(Request $request)
    {
        $id = $request->get('id');
        $model = $this->layananService->findById($id);
        $referrer = URL::previous();

        if ($model === null) {
            return abort(404, 'Not Found');
        }

        if ($request->isMethod('post')) {
            try {
                $data = $this->normalizeBooleanFields($request->all());
                $referrer = $request->post('referrer', $referrer);

                $model = $this->layananService->update($model, $data);

                return redirect($referrer)->with('success', 'Layanan berhasil diperbarui');
            } catch (ValidationException $e) {
                return redirect()->back()
                    ->withErrors($e->validator)
                    ->withInput()
                    ->with('danger', 'Data gagal disimpan. Silakan periksa kembali isian Anda.');
            }
        }

        return view('layanan.update', $this->getFormData(compact('model', 'referrer')));
    }

    public function view(Request $request)
    {
        $id = $request->get('id');
        $model = $this->layananService->findById($id);

        if ($model === null) {
            return abort(404, 'Not Found');
        }

        $allRefLayananKomponen = $this->refLayananKomponenService->findAll();

        $allLayananKomponen = $this->layananKomponenService->findAll([
            'id_layanan' => $model->id,
        ]);

        $groupLabels = RefLayananKomponen::getListGrup();

        return view('layanan.view', compact(
            'model',
            'allRefLayananKomponen',
            'allLayananKomponen',
            'groupLabels'
        ));
    }

    public function delete(Request $request)
    {
        $id = $request->get('id');
        $model = $this->layananService->findById($id);

        if ($model === null) {
            return abort(404, 'Not Found');
        }

        try {
            $this->layananService->delete($model);

            return redirect()->back()->with('success', 'Layanan berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('danger', 'Data gagal dihapus. Silakan coba lagi.');
        }
    }

    protected function getFormData(array $data = []): array
    {
        $listInstansi = $this->instansiService->getList();
        $listRefLayananPemicu = $this->refLayananPemicuService->getList();
        $listRefLayananTeknis = $this->refLayananTeknisService->getList();
        $listRefLayananPenerimaManfaat = $this->refLayananPenerimaManfaatService->getList();
        $listRefLayananProduk = $this->refLayananProdukService->getList();
        $listRefAtributBiaya = $this->refAtributBiayaService->getList();
        $listRefAtributSop = $this->refAtributSopService->getList();
        $listRefAtributSiklusLayanan = $this->refAtributSiklusLayananService->getList();
        $listRefAtributSkm = $this->refAtributSkmService->getList();

        return array_merge($data, compact(
            'listInstansi',
            'listRefLayananPemicu',
            'listRefLayananTeknis',
            'listRefLayananPenerimaManfaat',
            'listRefLayananProduk',
            'listRefAtributBiaya',
            'listRefAtributSop',
            'listRefAtributSiklusLayanan',
            'listRefAtributSkm'
        ));
    }

    protected function normalizeBooleanFields(array $data): array
    {
        $data['status_atribut_persyaratan'] = !empty($data['status_atribut_persyaratan']) ? 1 : 0;
        $data['status_atribut_prosedur'] = !empty($data['status_atribut_prosedur']) ? 1 : 0;

        return $data;
    }
}
