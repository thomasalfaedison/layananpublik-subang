<?php

namespace App\Services;

use App\Components\Session;
use App\Constants\JadwalJenisConstant;
use App\Constants\KuesionerConstant;

class DashboardService
{
    public function getInstansiService(): InstansiService
    {
        return app()->make(InstansiService::class);
    }

    public function getKuesionerRespondenService(): KuesionerRespondenService
    {
        return app()->make(KuesionerRespondenService::class);
    }

    public function getJadwalService(): JadwalService
    {
        return app()->make(JadwalService::class);
    }

    public function getJumlahInstansi(array $params = [])
    {
        $instansiService = $this->getInstansiService();
        return $instansiService->count($params);
    }

    protected function getAvgKuesionerRespondenByKolomResponden(string $attribute, array $params = []): float
    {
        $tahun = $params['tahun'] ?? Session::getTahun();
        $kode = $params['kode_kuesioner'] ?? KuesionerConstant::KODE_F01;

        $instansiService = $this->getInstansiService();
        $kuesionerRespondenService = $this->getKuesionerRespondenService();

        $kuesionerRespondenByInstansi = $kuesionerRespondenService->findAll([
            'kode_kuesioner' => $kode,
            'tahun' => $tahun,
        ])->keyBy('id_instansi');

        $totalInstansi = 0;
        $totalPersen = 0;

        foreach ($instansiService->findAll() as $instansi) {
            $kuesionerResponden = $kuesionerRespondenByInstansi->get($instansi->id);

            if ($kuesionerResponden != null) {
                $totalPersen += $kuesionerResponden->{$attribute};
            }

            $totalInstansi++;
        }

        $persen = $totalInstansi > 0
            ? $totalPersen / $totalInstansi
            : 0;

        return $persen;
    }

    public function getPersenPengisianKabupaten(array $params = []): float
    {
        return $this->getAvgKuesionerRespondenByKolomResponden('persen_pengisian', $params);
    }

    public function getPersenPenilaianKabupaten(array $params = []): float
    {
        return $this->getAvgKuesionerRespondenByKolomResponden('persen_penilaian', $params);
    }

    public function getRataRataNilaiKabupaten(array $params = []): float
    {
        return $this->getAvgKuesionerRespondenByKolomResponden('nilai_penilaian', $params);
    }

    public function getTopInstansiByKolomResponden(string $attribute, array $params = [])
    {
        $tahun = $params['tahun'] ?? Session::getTahun();

        $instansiService = $this->getInstansiService();
        $kode = KuesionerConstant::KODE_F01;

        $allInstansi = $instansiService->findAllWithKuesionerResponden($kode, [
            'tahun' => $tahun,
        ]);

        $allInstansiFiltered = $allInstansi
            ->sortByDesc(fn ($row) => $row->kuesionerResponden?->{$attribute})
            ->take(10)
            ->values();

        return $allInstansiFiltered;
    }

    public function getAllInstansiProgresPengisianTertinggi(array $params = [])
    {
        return $this->getTopInstansiByKolomResponden('persen_pengisian', $params);
    }

    public function getAllInstansiProgresPenilaianTertinggi(array $params = [])
    {
        return $this->getTopInstansiByKolomResponden('persen_penilaian', $params);
    }

    public function getAllInstansiNilaiPenilaianTertinggi(array $params = [])
    {
        return $this->getTopInstansiByKolomResponden('nilai_penilaian', $params);
    }

    public function getDistribusiBucketsByKolomResponden(string $attribute, array $params = [])
    {
        $tahun = $params['tahun'] ?? Session::getTahun();
        $kode  = KuesionerConstant::KODE_F01;

        $instansiService = $this->getInstansiService();

        $rows = $instansiService->findAllWithKuesionerResponden($kode, ['tahun' => $tahun]);

        $buckets = [
            '0–25'   => 0,
            '25–50'  => 0,
            '50–75'  => 0,
            '75–100' => 0,
        ];

        foreach ($rows as $row) {
            $p = (float)($row->kuesionerResponden->{$attribute} ?? 0);
            if ($p < 25)        $buckets['0–25']++;
            elseif ($p < 50)    $buckets['25–50']++;
            elseif ($p < 75)    $buckets['50–75']++;
            else                $buckets['75–100']++;
        }

        return [
            'labels' => array_keys($buckets),
            'values' => array_values($buckets),
        ];
    }

    public function getDistribusiPengisianBuckets(array $params = [])
    {
        return $this->getDistribusiBucketsByKolomResponden('persen_pengisian', $params);
    }

    public function getDistribusiPenilaianBuckets(array $params = [])
    {
        return $this->getDistribusiBucketsByKolomResponden('persen_penilaian', $params);
    }

    public function getDistribusiBucketsByNilaiPenilaian(array $params = [])
    {
        $tahun = $params['tahun'] ?? Session::getTahun();
        $kode  = KuesionerConstant::KODE_F01;

        $instansiService = $this->getInstansiService();

        $rows = $instansiService->findAllWithKuesionerResponden($kode, ['tahun' => $tahun]);

        $buckets = [
            '0' => 0,
            '1' => 0,
            '2' => 0,
            '3' => 0,
            '4' => 0,
            '5' => 0,
        ];

        foreach ($rows as $row) {
            $nilai = $row->kuesionerResponden->nilai_penilaian ?? 0;

            $bucket = (int) floor($nilai);

            if (array_key_exists($bucket, $buckets)) {
                $buckets[$bucket]++;
            }
        }

        return [
            'labels' => array_keys($buckets),
            'values' => array_values($buckets),
        ];
    }


    public function getDistribusiBucketsPenilaianBuckets(array $params = [])
    {
        return $this->getDistribusiBucketsByNilaiPenilaian($params);
    }

    public function getStatusPengisianKuesionerInstansi()
    {
        if (Session::isInstansi() == false) {
            return false;
        }

        $kuesionerRespondenService = $this->getKuesionerRespondenService();
        $id_instansi = Session::getIdInstansi();
        $tahun = Session::getTahun();

        $kuesionerResponden = $kuesionerRespondenService->findOne([
            'kode_kuesioner' => KuesionerConstant::KODE_F01,
            'id_instansi' => $id_instansi,
            'tahun' => $tahun
        ]);

        $status_pengisian = $kuesionerResponden != null;
        return $status_pengisian;
    }

    public function getJadwalPengisianAktif($tanggal = null)
    {
        if ($tanggal == null) {
            $tanggal = date('Y-m-d');
        }
        
        $jadwalService = $this->getJadwalService();

        $jadwalPengisian = $jadwalService->getActiveByJenis(
            JadwalJenisConstant::PENGISIAN,
            Session::getTahun(),
            $tanggal
        );

        return $jadwalPengisian;
    }

    public function getJadwalPengisianInfo(?string $tanggal = null): array
    {
        $tanggal = $tanggal ?? date('Y-m-d');
        $tahun = Session::getTahun();
        $jadwalService = $this->getJadwalService();

        // 1) Cek aktif (pakai method yang sudah dipakai di banyak tempat)
        $active = $jadwalService->getActiveByJenis(
            JadwalJenisConstant::PENGISIAN,
            $tahun,
            $tanggal
        );
        if ($active) {
            return ['status' => 'active', 'jadwal' => $active];
        }

        // 2) Kalau tidak aktif, cek yang akan datang
        $upcoming = $jadwalService->getUpcomingByJenis(
            JadwalJenisConstant::PENGISIAN,
            $tahun,
            $tanggal
        );
        
        if ($upcoming) {
            return ['status' => 'upcoming', 'jadwal' => $upcoming];
        }

        // 3) Kalau tidak ada upcoming, ambil terakhir yang sudah lewat
        $ended = $jadwalService->getLastEndedByJenis(
            JadwalJenisConstant::PENGISIAN,
            $tahun,
            $tanggal
        );
        if ($ended) {
            return ['status' => 'ended', 'jadwal' => $ended];
        }

        return ['status' => null, 'jadwal' => null];
    }

}