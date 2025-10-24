<?php

namespace App\Http\Controllers;

use App\Components\Helper;
use App\Components\Session;
use App\Constants\KuesionerConstant;
use App\Models\Instansi;
use App\Services\BeritaAcaraService;
use App\Services\InstansiJenisService;
use App\Services\InstansiKontakService;
use App\Services\InstansiService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\ValidationException;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class InstansiController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['auth'];
    }

    public function __construct(
        protected InstansiService $instansiService,
        protected InstansiJenisService $instansiJenisService,
        protected InstansiKontakService $instansiKontakService,
        protected BeritaAcaraService $beritaAcaraService,
    ) {}

    public function index(Request $request)
    {
        $params = $request->query();

        $allInstansi = $this->instansiService->paginate($params);

        return view('instansi.index',compact('allInstansi'));
    }

    public function indexPengisian(Request $request)
    {
        $params = $request->query();

        if (@$params['tahun'] == null) {
            $params['tahun'] = Session::getTahun();
        }

        $kode = KuesionerConstant::KODE_F01;

        if ($request->has('export-excel')) {
            return $this->exportExcelPengisian($request);
        }

        $allInstansi = $this->instansiService->paginateWithKuesionerResponden($kode, $params);

        return view('instansi.index-pengisian',compact('allInstansi'));
    }

    public function indexPenilaian(Request $request)
    {
        $params = $request->query();

        if (@$params['tahun'] == null) {
            $params['tahun'] = Session::getTahun();
        }
        
        $kode = KuesionerConstant::KODE_F01;

        if ($request->has('export-excel')) {
            return $this->exportExcelPenilaian($request);
        }

        $allInstansi = $this->instansiService->paginateWithKuesionerResponden($kode, $params);

        return view('instansi.index-penilaian',compact('allInstansi'));
    }

    public function indexBeritaAcara(Request $request)
    {
        $params = $request->query();

        if (@$params['tahun'] == null) {
            $params['tahun'] = Session::getTahun();
        }

        $tahun = $params['tahun'];

        $allInstansi = $this->instansiService->paginateWithBeritaAcara($params);

        return view('instansi.index-berita-acara', compact('allInstansi', 'tahun'));
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

        $listInstansiKontak = $this->instansiKontakService->findAll([
            'id_instansi' => $model->id,
        ]);

        return view('instansi.read',compact('model', 'listInstansiKontak'));
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

    public function exportExcelPengisian(Request $request)
    {
        $params = $request->query();
        $kode = KuesionerConstant::KODE_F01;

        $allInstansi = $this->instansiService->findAllWithKuesionerResponden($kode, $params);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Pengisian');

        $sheet->fromArray([
            ['No', 'Perangkat Daerah', 'Progres'],
        ], null, 'A1');
        $sheet->getStyle('A1:C1')->getFont()->setBold(true);

        $row = 2;
        foreach ($allInstansi as $index => $instansi) {
            $progress = $instansi->kuesionerResponden?->persen_pengisian;
            $sheet->setCellValue("A{$row}", $index + 1);
            $sheet->setCellValue("B{$row}", $instansi->nama);
            $sheet->setCellValue("C{$row}", Helper::rp($progress, 0, 2) . '%');
            $row++;
        }

        if ($row > 2) {
            $sheet->getStyle('C2:C' . ($row - 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        }

        foreach (range('A', 'C') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $filename = time() . '-pengisian-perangkat-daerah-.xlsx';

        return response()->streamDownload(function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Cache-Control' => 'max-age=0',
        ]);
    }

    public function exportExcelPenilaian(Request $request)
    {
        $params = $request->query();
        $kode = KuesionerConstant::KODE_F01;

        $allInstansi = $this->instansiService->findAllWithKuesionerResponden($kode, $params);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Penilaian');

        $sheet->fromArray([
            ['No', 'Perangkat Daerah', 'Progres', 'Nilai'],
        ], null, 'A1');
        $sheet->getStyle('A1:D1')->getFont()->setBold(true);

        $row = 2;
        foreach ($allInstansi as $index => $instansi) {
            $progress = $instansi->kuesionerResponden?->persen_penilaian;
            $nilai = $instansi->kuesionerResponden?->nilai_penilaian;

            $sheet->setCellValue("A{$row}", $index + 1);
            $sheet->setCellValue("B{$row}", $instansi->nama);
            $sheet->setCellValue("C{$row}", Helper::rp($progress, 0, 2) . '%');
            $sheet->setCellValue("D{$row}", Helper::rp($nilai, 0, 2));
            $row++;
        }

        if ($row > 2) {
            $sheet->getStyle('C2:D' . ($row - 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        }

        foreach (range('A', 'D') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $filename = time() . '-penilaian-perangkat-daerah.xlsx';

        return response()->streamDownload(function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Cache-Control' => 'max-age=0',
        ]);
    }
}
