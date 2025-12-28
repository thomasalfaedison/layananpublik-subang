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
        protected InstansiService $instansiService,
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

        $payload = $this->buildPayload($model);

        $pdf = Pdf::loadView('layanan.export-pdf', $payload)
            ->setPaper('A4', 'portrait');

        $filename = sprintf(
            'layanan-%s.pdf',
            Str::slug($model->nama)
        );

        return $pdf->stream($filename);
    }

    public function streamAll(array $params = [])
    {
        $id_instansi = $params['id_instansi'];

        $instansi = $this->instansiService->findById($id_instansi);

        $allLayanan = $this->layananService->findAll($params);

        $allRefLayananKomponen = $this->refLayananKomponenService->findAll();
        $groupLabels = RefLayananKomponen::getListGrup();

        $idLayananList = $allLayanan->pluck('id')->all();

        $allLayananKomponen = $this->layananKomponenService->findAll([
            'array_id_layanan' => $idLayananList,
        ])->groupBy('id_layanan');

        $details = $allLayanan->map(function ($layanan) use ($allRefLayananKomponen, $groupLabels, $allLayananKomponen) {
            $payload = $this->buildPayload(
                $layanan,
                $allRefLayananKomponen,
                $groupLabels,
                $allLayananKomponen
            );

            return [
                'model' => $payload['model'],
                'allLayananKomponen' => $payload['allLayananKomponen'],
            ];
        });

        $pdf = Pdf::loadView('layanan.export-pdf-all', [
            'details' => $details,
            'allRefLayananKomponen' => $allRefLayananKomponen,
            'groupLabels' => $groupLabels,
        ])->setPaper('A4', 'portrait');

        $filename = strtolower($instansi->id.'-'.$instansi->nama);
        $filename = str_replace(',','',$filename);
        $filename = str_replace(' ','-',$filename);

        return $pdf->stream($filename.'.pdf');
    }

    protected function buildPayload($model, $allRefLayananKomponen = null, $groupLabels = null, $groupedLayananKomponen = null): array
    {
        $allRefLayananKomponen = $allRefLayananKomponen ?? $this->refLayananKomponenService->findAll();
        $groupLabels = $groupLabels ?? RefLayananKomponen::getListGrup();

        $allLayananKomponen = $groupedLayananKomponen
            ? ($groupedLayananKomponen->get($model->id) ?? collect())
            : $this->layananKomponenService->findAll([
                'id_layanan' => $model->id,
            ]);

        return [
            'model' => $model,
            'allRefLayananKomponen' => $allRefLayananKomponen,
            'allLayananKomponen' => $allLayananKomponen,
            'groupLabels' => $groupLabels,
        ];
    }
}
