<?php

namespace App\Http\Controllers;

use App\Components\Session;
use App\Models\StandarPelayanan;
use App\Services\InstansiService;
use App\Services\StandarPelayananExportService;
use App\Services\StandarPelayananService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\ValidationException;

class StandarPelayananController extends Controller implements HasMiddleware
{
    public const ROUTE_INDEX = 'standar-pelayanan.index';
    public const ROUTE_CREATE = 'standar-pelayanan.create';
    public const ROUTE_CREATE_PROCESS = 'standar-pelayanan.createProcess';
    public const ROUTE_UPDATE = 'standar-pelayanan.update';
    public const ROUTE_UPDATE_PROCESS = 'standar-pelayanan.updateProcess';
    public const ROUTE_DELETE = 'standar-pelayanan.delete';
    public const ROUTE_EXPORT_PDF = 'standar-pelayanan.export-pdf';

    public static function middleware()
    {
        return ['auth'];
    }

    public function __construct(
        protected StandarPelayananService $standarPelayananService,
        protected InstansiService $instansiService,
        protected StandarPelayananExportService $exportService,
    ) {
    }

    public function index(Request $request)
    {
        $params = $request->query();

        if (Session::isInstansi()) {
            $params['id_instansi'] = Session::getIdInstansi();
        }

        $allStandarPelayanan = $this->standarPelayananService->paginate($params);

        $listInstansi = $this->instansiService->getList();

        return view('standar-pelayanan.index', compact(
            'allStandarPelayanan',
            'listInstansi',
        ));
    }

    public function create(Request $request)
    {
        $model = new StandarPelayanan();
        $referrer = URL::previous();

        if ($request->isMethod('post')) {
            try {
                $data = $request->all();
                $referrer = $request->post('referrer', $referrer);

                $this->standarPelayananService->create($data);

                return redirect(route(self::ROUTE_INDEX))
                    ->with('success', 'Standar Pelayanan berhasil dibuat');
            } catch (ValidationException $e) {
                return redirect()->back()
                    ->withErrors($e->validator)
                    ->withInput()
                    ->with('danger', 'Data gagal disimpan. Silakan periksa kembali isian Anda.');
            }
        }

        return view('standar-pelayanan.create', $this->getFormData([
            'model' => $model,
            'referrer' => $referrer,
            'action' => route(self::ROUTE_CREATE_PROCESS),
        ]));
    }

    public function update(Request $request)
    {
        $id = $request->get('id');
        $model = $this->standarPelayananService->findById((int) $id);
        $referrer = URL::previous();

        if ($model === null) {
            return abort(404, 'Not Found');
        }

        if ($request->isMethod('post')) {
            try {
                $data = $request->all();
                $referrer = $request->post('referrer', $referrer);

                $this->standarPelayananService->update($model, $data);

                return redirect($referrer)->with('success', 'Standar Pelayanan berhasil diperbarui');
            } catch (ValidationException $e) {
                return redirect()->back()
                    ->withErrors($e->validator)
                    ->withInput()
                    ->with('danger', 'Data gagal disimpan. Silakan periksa kembali isian Anda.');
            }
        }

        return view('standar-pelayanan.update', $this->getFormData([
            'model' => $model,
            'referrer' => $referrer,
            'action' => route(self::ROUTE_UPDATE_PROCESS, ['id' => $model->id]),
        ]));
    }

    public function delete(Request $request)
    {
        $id = (int) $request->get('id');
        $model = $this->standarPelayananService->findById($id);

        if ($model === null) {
            return abort(404, 'Not Found');
        }

        try {
            $this->standarPelayananService->delete($model);

            return redirect()->back()->with('success', 'Standar Pelayanan berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('danger', 'Data gagal dihapus. Silakan coba lagi.');
        }
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

    protected function getFormData(array $data = []): array
    {
        $listInstansi = $this->instansiService->getList();

        return array_merge($data, compact('listInstansi'));
    }
}
