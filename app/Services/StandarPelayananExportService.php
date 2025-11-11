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

        $standarPelayanan = $this->standarPelayananService->findByInstansi($id_instansi);

        $allLayanan = $this->layananService->findAll($params);

        $allLayananKomponen = $this->layananKomponenService->findAll([
            'id_instansi' => $id_instansi,
        ]);

        $listRefLayananKomponen = $this->refLayananKomponenService->findAll();

        $listGrupLabel = RefLayananKomponen::getListGrup();

        return [
            'document' => [
                'number' => '188.4/1234/KPTS-B.ORGAN/2025',
                'date' => '10 Januari 2025',
                'title' => 'Keputusan Kepala Perangkat Daerah Tentang Standar Pelayanan',
                'preamble' => 'Dalam rangka memberikan kepastian terhadap kualitas pelayanan publik dan memastikan terpenuhinya hak masyarakat, setiap perangkat daerah wajib menetapkan standar pelayanan yang menjadi acuan utama dalam penyelenggaraan layanan.',
            ],
            'service' => [
                'name' => 'Pelayanan Perizinan Usaha Mikro dan Kecil',
                'description' => 'Pelayanan penerbitan dan pembaharuan perizinan usaha mikro dan kecil sebagai bentuk fasilitasi pemerintah daerah untuk pelaku usaha.',
                'vision' => 'Terwujudnya pelayanan perizinan usaha mikro yang cepat, pasti, transparan, dan berorientasi pada kepuasan masyarakat.',
                'mission' => [
                    'Memastikan seluruh persyaratan dapat dipenuhi secara daring maupun luring dengan panduan yang jelas.',
                    'Menghadirkan petugas layanan yang responsif terhadap keluhan dan kebutuhan pemohon.',
                    'Memberikan kepastian waktu penyelesaian perizinan sesuai standar yang ditetapkan.',
                ],
            ],
            'components' => [
                ['label' => 'Dasar Hukum', 'value' => 'UU No. 25 Tahun 2009 tentang Pelayanan Publik, Perda Kabupaten Subang No. 4 Tahun 2023, dan Keputusan Bupati Subang No. 188.4/2023 tentang Penyelenggaraan Pelayanan Terpadu.'],
                ['label' => 'Persyaratan', 'value' => 'Formulir permohonan, KTP pemohon, NPWP, surat keterangan domisili usaha, dan proposal usaha singkat.'],
                ['label' => 'Sistem, Mekanisme, dan Prosedur', 'value' => 'Pendaftaran melalui loket/website, verifikasi berkas, klarifikasi lapangan (bila diperlukan), penandatanganan izin, dan penyerahan dokumen.'],
                ['label' => 'Waktu Penyelesaian', 'value' => '3 (tiga) hari kerja sejak berkas dinyatakan lengkap.'],
                ['label' => 'Biaya/Tarif', 'value' => 'Tidak dipungut biaya (gratis).'],
                ['label' => 'Produk Layanan', 'value' => 'Surat Izin Usaha Mikro dan Kecil (IUMK) yang sah dan tercatat dalam basis data pemerintah daerah.'],
                ['label' => 'Sarana dan Prasarana', 'value' => 'Loket pelayanan terpadu, kanal layanan daring, call center, ruang tunggu, serta perangkat anjungan mandiri.'],
                ['label' => 'Pengelolaan Pengaduan', 'value' => 'Pengaduan disampaikan melalui aplikasi LAPOR!, nomor layanan 1500-123, atau loket pengaduan langsung.'],
                ['label' => 'Jaminan Pelayanan', 'value' => 'Setiap pemohon mendapatkan tanda terima elektronik dan notifikasi status permohonan secara berkala.'],
                ['label' => 'Evaluasi Kinerja', 'value' => 'Evaluasi internal dilakukan triwulanan oleh Tim Peningkatan Kualitas Pelayanan dengan melibatkan survei kepuasan masyarakat.'],
            ],
            'commitments' => [
                'Memberikan pelayanan tanpa diskriminasi kepada seluruh masyarakat Kabupaten Subang.',
                'Menjamin transparansi informasi terkait status permohonan dan standar pelayanan.',
                'Menindaklanjuti pengaduan paling lambat 2 (dua) hari kerja setelah diterima.',
            ],
            'generated_at' => now()->format('d F Y H:i') . ' WIB',
            'instansi' => $instansi,
            'standarPelayanan' => $standarPelayanan,
            'allLayanan' => $allLayanan,
            'allLayananKomponen' => $allLayananKomponen,
            'listRefLayananKomponen' => $listRefLayananKomponen,
            'listGrupLabel' => $listGrupLabel,
        ];
    }
}
