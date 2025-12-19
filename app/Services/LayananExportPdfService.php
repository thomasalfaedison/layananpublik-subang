<?php

namespace App\Services;

use App\Models\RefLayananKomponen;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

class LayananExportPdfService
{
    public function __construct(
        protected LayananService $layananService,
        protected RefLayananKomponenService $refLayananKomponenService,
        protected LayananKomponenService $layananKomponenService,
    ) {
    }

    public function stream(array $params = [])
    {
        $id = $params['id'] ?? null;

        if ($id === null) {
            throw new \InvalidArgumentException('id tidak boleh kosong');
        }

        $model = $this->layananService->findById($id);

        if ($model === null) {
            abort(404, 'Layanan tidak ditemukan');
        }

        $allRefLayananKomponen = $this->refLayananKomponenService->findAll();
        $allLayananKomponen = $this->layananKomponenService->findAll([
            'id_layanan' => $model->id,
        ]);
        $groupLabels = RefLayananKomponen::getListGrup();

        $payload = [
            'model' => $model,
            'allRefLayananKomponen' => $allRefLayananKomponen,
            'allLayananKomponen' => $allLayananKomponen,
            'groupLabels' => $groupLabels,
        ];

        $pdf = Pdf::loadView('layanan.export-pdf', $payload)
            ->setPaper('A4', 'portrait');

        $filename = sprintf(
            'layanan-%s.pdf',
            Str::slug($model->nama)
        );

        return $pdf->stream($filename);
    }
}
