<?php

namespace App\Http\Controllers;

use App\Models\Instansi;
use App\Services\InstansiJenisService;
use App\Services\InstansiService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\ValidationException;

class InstansiController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['auth'];
    }

    public function __construct(
        protected InstansiService $instansiService,
        protected InstansiJenisService $instansiJenisService,
    ) {}

    public function index(Request $request)
    {
        $params = $request->query();

        $allInstansi = $this->instansiService->paginate($params);

        return view('instansi.index',compact('allInstansi'));
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
