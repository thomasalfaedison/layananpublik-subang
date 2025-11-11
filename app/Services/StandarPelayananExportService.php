<?php

namespace App\Services;

use App\Models\RefLayananKomponen;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

class StandarPelayananExportService
{
    public function __construct(
        protected InstansiService $instansiService,
        protected LayananService $layananService,
        protected LayananKomponenService $layananKomponenService,
        protected RefLayananKomponenService $refLayananKomponenService,
        protected StandarPelayananService $standarPelayananService,
    ) {
    }

    public function stream(array $params = [])
    {
        $payload = $this->buildPayload($params);

        $pdf = Pdf::loadView('standar-pelayanan.export-pdf', $payload)
            ->setPaper('A4', 'portrait');

        $filename = sprintf(
            'standar-pelayanan-%s.pdf',
            Str::slug(@$payload['instansi']->nama)
        );

        return $pdf->stream($filename);
    }

    protected function buildPayload(array $params = []): array
    {
        $id_instansi = $params['id_instansi'] ?? null;

        if ($id_instansi === null) {
            throw new \InvalidArgumentException('id_instansi tidak boleh kosong');
        }

        $instansi = $this->instansiService->findById($id_instansi);

        if ($instansi === null) {
            abort(404, 'Instansi tidak ditemukan');
        }

        $standarPelayanan = $this->standarPelayananService->firstOrCreate([
            'id_instansi' => $id_instansi,
        ]);

        $allLayanan = $this->layananService->findAll($params);

        $allLayananKomponen = $this->layananKomponenService->findAll([
            'id_instansi' => $id_instansi,
        ]);

        $listRefLayananKomponen = $this->refLayananKomponenService->findAll();

        $listGrupLabel = RefLayananKomponen::getListGrup();

        return [
            'instansi' => $instansi,
            'standarPelayanan' => $standarPelayanan,
            'allLayanan' => $allLayanan,
            'allLayananKomponen' => $allLayananKomponen,
            'listRefLayananKomponen' => $listRefLayananKomponen,
            'listGrupLabel' => $listGrupLabel,
        ];
    }
}
