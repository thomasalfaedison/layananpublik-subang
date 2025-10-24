<?php

namespace App\Http\Controllers;

use App\Components\Session;
use App\Constants\KuesionerConstant;
use App\Services\InstansiKontakService;
use App\Services\InstansiService;
use App\Services\KuesionerJawabanService;
use App\Services\KuesionerPertanyaanTreeService;
use App\Services\KuesionerService;
use App\Services\RefJenisKelaminService;
use App\Services\RefPekerjaanService;
use App\Services\RefPendidikanService;
use Illuminate\Http\Request;

class SiteController
{
    public static function middleware()
    {
        return ['auth'];
    }

    public function __construct(
        protected InstansiService $instansiService,
        protected KuesionerService $kuesionerService,
        protected InstansiKontakService $instansiKontakService,
        protected KuesionerJawabanService $kuesionerJawabanService,
        protected RefJenisKelaminService $refJenisKelaminService,
        protected RefPendidikanService $refPendidikanService,
        protected RefPekerjaanService $refPekerjaanService,
        protected KuesionerPertanyaanTreeService $kuesionerPertanyaanTreeService,
    ) {}

    public function kuesionerResponden(Request $request)
    {
        $id_instansi = $request->input('id_instansi');
        $instansiSingkatan = $request->query('instansi');
        if (empty($instansiSingkatan)) {
            $instansiSingkatan = $request->input('instansi');
        }

        $kode = $request->get('kode', '-');
        $tahun = date('Y'); // untuk publik/masyarakat otomatis menggunakan tahun berjalan

        $lockInstansi = false;
        $selectedInstansiName = null;

        if (!$id_instansi) {
            if (!empty($instansiSingkatan)) {
                $instansi = $this->instansiService->findOne([
                    'singkatan' => $instansiSingkatan,
                    'tahun' => $tahun,
                ]);

                if ($instansi) {
                    $id_instansi = $instansi->id;
                    $selectedInstansiName = $instansi->nama;
                    $lockInstansi = true;
                }
            }
        }

        if (Session::isInstansi()) {
            $id_instansi = Session::getIdInstansi();
            $lockInstansi = true;
        }

        if ($kode == KuesionerConstant::KODE_F01 OR $kode == KuesionerConstant::KODE_F02) {
            abort(403);
        }
        
        $kuesioner = $this->kuesionerService->findOrFail([
            'kode' => $kode,
            'tahun' => $tahun,
        ]);

        if ($request->isMethod('POST')) {
            $data = $request->except('_token');
            $data['id_instansi'] = $id_instansi;

            try {
                $this->kuesionerJawabanService->validateRespondenData($data);
                $encoded = base64_encode(json_encode($data));
                return redirect('/site/kuesioner-isi?data=' . urlencode($encoded));
            } catch (\Illuminate\Validation\ValidationException $e) {
                return redirect()->back()
                    ->withErrors($e->validator)
                    ->withInput();
            }
        }

        $listInstansi = $this->instansiService->getList();
        if ($id_instansi && !$selectedInstansiName) {
            $selectedInstansiName = $listInstansi[$id_instansi] ?? optional($this->instansiService->findById($id_instansi))->nama;
        }
        $listRefJenisKelamin = $this->refJenisKelaminService->getList();
        $listRefPendidikan = $this->refPendidikanService->getList();
        $listRefPekerjaan = $this->refPekerjaanService->getList();

        return view('site.kuesioner-responden', [
            'kuesioner' => $kuesioner,
            'listInstansi' => $listInstansi,
            'listRefJenisKelamin' => $listRefJenisKelamin,
            'listRefPendidikan' => $listRefPendidikan,
            'listRefPekerjaan' => $listRefPekerjaan,
            'id_instansi' => $id_instansi,
            'lockInstansi' => $lockInstansi,
            'instansiSingkatan' => $instansiSingkatan,
            'selectedInstansiName' => $selectedInstansiName,
        ]);
    }

    public function kuesionerIsi(Request $request)
    {
        $data = $request->get('data');
        $respondenData = json_decode(base64_decode($data), true);

        if ($respondenData == null) {
            abort(400, 'Data tidak valid');
        }

        if ($request->isMethod('POST')) {
            try {
                $jawabanForm = $request->input('jawaban', []);
                $this->kuesionerJawabanService->simpanPenilaianMasyarakat($respondenData, $jawabanForm);
                return redirect('/site/kuesioner-sukses?data=' . $data);
            } catch (\Exception $e) {
                dd($e->getMessage());
                return redirect()->back()->with('error', 'Gagal menyimpan jawaban: ' . $e->getMessage())->withInput();
            }
        }

        $kode = $respondenData['kode'] ?? '-';
        $id_instansi = $respondenData['id_instansi'] ?? '-';
        $tahun = $respondenData['tahun'] ?? date('Y');

        $kuesioner = $this->kuesionerService->findOrFail([
            'kode' => $kode,
            'tahun' => $tahun,
        ]);
        
        $listInstansiKontak = $this->instansiKontakService->findAll([
            'id_instansi' => $id_instansi,
        ]);

        $listKuesionerPertanyaanRecursive = $this->kuesionerPertanyaanTreeService->findAllKuesionerPertanyaanRecursive($kuesioner->id);

        return view('site.kuesioner-isi', [
            'data' => $data,
            'kuesioner' => $kuesioner,
            'listInstansiKontak' => $listInstansiKontak,
            'listKuesionerPertanyaanRecursive' => $listKuesionerPertanyaanRecursive,
        ]);
    }

    public function kuesionerSukses(Request $request)
    {
        $data = $request->get('data');
        $respondenData = json_decode(base64_decode($data), true);

        if ($respondenData == null) {
            abort(400, 'Data tidak valid');
        }

        $kode = $respondenData['kode'] ?? '-';
        $id_instansi = $respondenData['id_instansi'] ?? 0;
        $tahun = $respondenData['tahun'] ?? date('Y');

        $kuesioner = $this->kuesionerService->findOrFail([
            'kode' => $kode,
            'tahun' => $tahun,
        ]);

        $instansi = $this->instansiService->findById($id_instansi);

        return view('site.kuesioner-sukses', [
            'kuesioner' => $kuesioner,
            'instansi' => $instansi,
            'respondenData' => $respondenData,
        ]);
    }
}
