<?php

namespace App\Http\Controllers;

use App\Components\Session;
use App\Models\LayananKomponen;
use App\Services\LayananKomponenService;
use App\Services\LayananService;
use App\Services\RefLayananKomponenService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\ValidationException;

class LayananKomponenController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['auth'];
    }

    public function __construct(
        protected LayananKomponenService $layananKomponenService,
        protected LayananService $layananService,
        protected RefLayananKomponenService $refLayananKomponenService,
    ) {
    }

    public function index(Request $request)
    {
        $params = $request->query();

        if (Session::isInstansi()) {
            $params['id_instansi'] = Session::getIdInstansi();
        }

        $allLayananKomponen = $this->layananKomponenService->paginate($params);
        $listLayanan = $this->getListLayanan();
        $listRefLayananKomponen = $this->refLayananKomponenService->getList();

        return view('layanan-komponen.index', compact(
            'allLayananKomponen',
            'listLayanan',
            'listRefLayananKomponen',
            'params'
        ));
    }

    public function create(Request $request)
    {
        $id_layanan = $request->query('id_layanan');
        $id_ref_layanan_komponen = $request->query('id_ref_layanan_komponen');

        $model = new LayananKomponen();
        $model->id_layanan = $id_layanan;
        $model->id_ref_layanan_komponen = $id_ref_layanan_komponen;

        $referrer = URL::previous();

        if ($request->isMethod('post')) {
            try {
                $referrer = $request->post('referrer', $referrer);
                $model = $this->layananKomponenService->create($request->all());

                return redirect($referrer)->with('success', 'Komponen layanan berhasil dibuat');
            } catch (ValidationException $e) {
                return redirect()->back()
                    ->withErrors($e->validator)
                    ->withInput()
                    ->with('danger', 'Data gagal disimpan. Silakan periksa kembali isian Anda.');
            }
        }

        return view('layanan-komponen.create', $this->getFormData(compact('model', 'referrer')));
    }

    public function update(Request $request)
    {
        $id = (int) $request->get('id');
        $model = $this->layananKomponenService->findById($id);
        $referrer = URL::previous();

        if ($model === null) {
            return abort(404, 'Not Found');
        }

        if ($request->isMethod('post')) {
            try {
                $referrer = $request->post('referrer', $referrer);
                $model = $this->layananKomponenService->update($model, $request->all());

                return redirect($referrer)->with('success', 'Komponen layanan berhasil diperbarui');
            } catch (ValidationException $e) {
                return redirect()->back()
                    ->withErrors($e->validator)
                    ->withInput()
                    ->with('danger', 'Data gagal disimpan. Silakan periksa kembali isian Anda.');
            }
        }

        return view('layanan-komponen.update', $this->getFormData(compact('model', 'referrer')));
    }

    public function view(Request $request)
    {
        $id = (int) $request->get('id');
        $model = $this->layananKomponenService->findById($id);

        if ($model === null) {
            return abort(404, 'Not Found');
        }

        return view('layanan-komponen.view', compact('model'));
    }

    public function delete(Request $request)
    {
        $id = (int) $request->get('id');
        $model = $this->layananKomponenService->findById($id);

        if ($model === null) {
            return abort(404, 'Not Found');
        }

        try {
            $this->layananKomponenService->delete($model);

            return redirect()->back()->with('success', 'Komponen layanan berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('danger', 'Data gagal dihapus. Silakan coba lagi.');
        }
    }

    protected function getFormData(array $data = []): array
    {
        $listLayanan = $this->getListLayanan();
        $listRefLayananKomponen = $this->refLayananKomponenService->getList();

        return array_merge($data, compact('listLayanan', 'listRefLayananKomponen'));
    }

    protected function getListLayanan(): array
    {
        $params = [];

        if (Session::isInstansi()) {
            $params['id_instansi'] = Session::getIdInstansi();
        }

        return $this->layananService->getList($params);
    }
}

