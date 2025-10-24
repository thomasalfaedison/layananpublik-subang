<?php

namespace App\Http\Controllers;

use App\Components\Session;
use App\Constants\UserConstant;
use App\Models\User;
use App\Services\ExportExcelUserService;
use App\Services\InstansiService;
use App\Services\RoleService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\ValidationException;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class UserController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['auth'];
    }

    public function __construct(
        protected UserService $userService,
        protected RoleService $roleService,
        protected InstansiService $instansiService,
        protected ExportExcelUserService $exportExcelUserService
    ) {}

    public function index(Request $request)
    {
        $params = $request->query();
        $id_role = @$params['id_role'];

        $allUser = $this->userService->paginate($params);
        $listUserRole = $this->roleService->getList();

        $namaRole = @$listUserRole[$id_role];

        return view('user.index',compact('allUser','id_role', 'namaRole'));
    }

    public function create(Request $request)
    {
        $params = $request->query();
        $id_role = @$params['id_role'];

        $model = new User();
        $model->id_role = $id_role;

        $referrer = URL::previous();

        if ($request->isMethod('post'))
        {
            try {
                $referrer = $request->post('referrer');
                $this->userService->create($request->all());

                return redirect($referrer)->with('success', 'User berhasil dibuat');
            } catch (ValidationException $e) {
                return redirect()->back()
                    ->withErrors($e->validator)
                    ->withInput()
                    ->with('danger', 'Data gagal disimpan. Silahkan periksa kembali isian Anda.');
            }
        }

        $listUserRole = $this->roleService->getList();
        $listInstansi = $this->instansiService->getList();

        return view('user.create',compact('model','referrer', 'listUserRole', 'listInstansi'));

    }

    public function update(Request $request)
    {
        $id = $request->get('id');

        $model = $this->userService->findById($id);

        if ($model == null)
        {
            return abort('404','Not Found');
        }

        $referrer = URL::previous();

        if ($request->isMethod('post'))
        {
            try {
                $referrer = $request->post('referrer');
                $data = $this->userService->update($model, $request->all());

                return redirect($referrer)->with('success', 'User berhasil diupdate');
            } catch (ValidationException $e) {
                return redirect()->back()
                    ->withErrors($e->validator)
                    ->withInput()
                    ->with('danger', 'Data gagal disimpan. Silahkan periksa kembali isian Anda.');
            }
        }

        $listUserRole = $this->roleService->getList();
        $listInstansi = $this->instansiService->getList();

        return view('user.update',compact('model','referrer', 'listUserRole', 'listInstansi'));
    }

    public function setPassword(Request $request)
    {
        $id = $request->get('id');
        $model = $this->userService->findById($id);

        if ($model == null)
        {
            return abort('404','Not Found');
        }

        $referrer = URL::previous();

        if ($request->isMethod('post'))
        {
            try {
                $referrer = $request->post('referrer');
                $this->userService->setPassword($model, $request->all());

                return redirect($referrer)->with('success', 'Password user berhasil diupdate');
            } catch (ValidationException $e) {
                return redirect()->back()
                    ->withErrors($e->validator)
                    ->withInput()
                    ->with('danger', 'Data gagal disimpan. Silahkan periksa kembali isian Anda.');
            }
        }

        return view('user.set-password',compact('model','referrer'));
    }

    public function changePassword(Request $request)
    {
        $id = Session::getIdUser();
        $model = $this->userService->findById($id);

        if ($model == null)
        {
            return abort('404','Not Found');
        }

        if ($request->isMethod('post'))
        {
            try {
                $referrer = $request->post('referrer');
                $this->userService->changePassword($model, $request->all());

                return back()->with('success', 'Password berhasil diubah');
            } catch (ValidationException $e) {
                return back()
                    ->withErrors($e->validator)
                    ->withInput()
                    ->with('danger', 'Data gagal disimpan. Silahkan periksa kembali isian Anda.');
            }
        }

        return view('user.change-password',compact('model'));
    }

    public function read(Request $request)
    {
        $id = $request->get('id');

        $model = $this->userService->findById($id);

        if ($model == null)
        {
            return abort('404','Not Found');
        }

        $listUserRole = $this->roleService->getList();

        return view('user.read',compact('model','listUserRole'));
    }

    public function delete(Request $request)
    {
        $id = $request->get('id');
        $model = $this->userService->findById($id);

        if ($model == null) {
            return abort('404', 'Not Found');
        }

        try {
            $this->userService->delete($model);
            return redirect()->back()->with('success', 'user pertanyaan berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('danger', 'Data gagal dihapus. Silakan coba lagi.');
        }
    }

    public function resetPasswordDefaultAll()
    {
        $this->userService->resetPasswordDefault([
            'id_role' => UserConstant::ROLE_INSTANSI,
        ]);

        return redirect()->back()->with('success', 'Semua password perangkat daerah berhasil direset ke default: subangkab2025');
    }

    public function exportExcel(Request $request)
    {
        $params = $request->query();
        $id_role = @$params['id_role'];

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $listRole = $this->roleService->getList();
        $namaRole = $listRole[$id_role] ?? '';

        // Title
        $this->exportExcelUserService->getTitle($sheet, $params, $listRole);
        // Header
        $startRow=3;

        $headerInfo = $this->exportExcelUserService->getHeader($sheet, $startRow, $params);
        $row = $headerInfo['row'];
        $lastColumn = $headerInfo['last_column'];

        // Body
        $row = $this->exportExcelUserService->getBody($sheet, $row + 1, $params);

        //styling
        $sheet->getStyle(sprintf('A%d:%s%d', $startRow, $lastColumn, $row - 1))->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ]);


        // (Opsional) Auto-size kolom A???G
        foreach (range('A', $lastColumn) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);

        // Output as download
        $filename = 'daftar_user_'.$namaRole.'.xlsx';

        $temp_file = tempnam(sys_get_temp_dir(), $filename);
        $writer->save($temp_file);

        return response()->download($temp_file, $filename)->deleteFileAfterSend(true);
    }
}

