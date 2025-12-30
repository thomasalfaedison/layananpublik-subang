<?php

namespace App\Services;

use App\Components\Session;
use Illuminate\Support\Collection;

class DashboardService
{
    public function getInstansiService(): InstansiService
    {
        return app()->make(InstansiService::class);
    }

    public function getLayananService(): LayananService
    {
        return app()->make(LayananService::class);
    }

    public function getJumlahInstansi(array $params = [])
    {
        $instansiService = $this->getInstansiService();
        return $instansiService->count($params);
    }

    public function getJumlahLayanan(array $params = [])
    {
        $layananService = $this->getLayananService();

        if (Session::isInstansi()) {
            $params['id_instansi'] = Session::getIdInstansi();
        }

        return $layananService->count($params);
    }

    public function getAllInstansi(array $params = [])
    {
        $instansiService = $this->getInstansiService();
        return $instansiService->findAll($params);
    }

    public function getInstansiSummary(array $array_id_instansi = []): Collection
    {
        $layananService = $this->getLayananService();

        $params = [];

        if (!empty($array_id_instansi)) {
            $params['array_id_instansi'] = $array_id_instansi;
        }

        return $layananService->summarizeByInstansi($params);
    }

    public function getLayananSummaryByProduk(): Collection
    {
        $layananService = $this->getLayananService();
        return $layananService->summarizeByProduk();
    }

    public function getLayananSummaryByPenerimaManfaat(): Collection
    {
        $layananService = $this->getLayananService();
        return $layananService->summarizeByPenerimaManfaat();
    }

    public function getLayananPivotPenerimaVsProduk(): array
    {
        $layananService = $this->getLayananService();
        return $layananService->pivotPenerimaVsProduk();
    }
}
