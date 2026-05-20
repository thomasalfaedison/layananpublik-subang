<?php

namespace App\Services;

use App\Components\Helper;
use App\Models\RefLayananKomponen;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\SimpleType\Jc;
use PhpOffice\PhpWord\SimpleType\JcTable;

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

    public function streamWordBeritaAcara(array $params = [])
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

        $phpWord = $this->buildBeritaAcaraDocument([
            'instansi' => $instansi,
            'allLayanan' => $allLayanan,
            'standarPelayanan' => $standarPelayanan,
        ]);

        $tmpBase = tempnam(sys_get_temp_dir(), 'ba-sp-');
        $tmpFile = $tmpBase . '.docx';

        if ($tmpBase !== false && file_exists($tmpBase)) {
            @unlink($tmpBase);
        }

        $writer = IOFactory::createWriter($phpWord, 'Word2007');
        $writer->save($tmpFile);

        $filename = sprintf(
            'berita-acara-standar-pelayanan-%s.docx',
            Str::slug($instansi->nama),
        );

        return response()->download($tmpFile, $filename)->deleteFileAfterSend(true);
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

    protected function buildBeritaAcaraDocument(array $payload): PhpWord
    {
        $instansi = $payload['instansi'];
        $standarPelayanan = $payload['standarPelayanan'];
        $allLayanan = $payload['allLayanan'];

        $phpWord = new PhpWord();
        $phpWord->setDefaultFontName('Bookman Old Style');
        $phpWord->setDefaultFontSize(12);

        $phpWord->addNumberingStyle(
            'numbering',
            [
                'type' => 'multilevel',
                'levels' => [
                    [
                        'format' => 'decimal',
                        'text' => '%1.',
                        'left' => 450,
                        'hanging' => 450,
                    ],
                ],
            ]
        );

        $section = $phpWord->addSection([
            'marginTop' => 1440,
            'marginRight' => 1440,
            'marginBottom' => 1440,
            'marginLeft' => 1440,
        ]);

        $titleStyle = [
            'bold' => true,
            'name' => 'Bookman Old Style',
            'size' => 12,
        ];

        $centerNoSpace = [
            'alignment' => Jc::CENTER,
            'spaceAfter' => 0,
            'lineHeight' => 1,
        ];

        $justifyFirstLine = [
            'indentation' => ['firstLine' => 900],
            'lineHeight' => 1.15,
        ];

        $listParagraphStyle = [
            'alignment' => Jc::BOTH,
            'lineHeight' => 1,
        ];

        $section->addText('BERITA ACARA', $titleStyle, $centerNoSpace);
        $section->addText('KESEPAKATAN STANDAR PELAYANAN', $titleStyle, $centerNoSpace);
        $section->addText('PADA ' . strtoupper($instansi->nama) . ' KABUPATEN SUBANG', $titleStyle, $centerNoSpace);
        $section->addTextBreak(2);

        $jumlahLayanan = $allLayanan->count();
        $jumlahLayananTerbilang = trim(Helper::getTerbilang($jumlahLayanan));
        $jumlahLayananTerbilang = $jumlahLayananTerbilang !== ''
            ? strtolower($jumlahLayananTerbilang)
            : 'nol';

        $introRuns = $section->addTextRun($justifyFirstLine);
        $introRuns->addText('Pada hari ini .........., tanggal ... bulan .... tahun ');
        $introRuns->addText(
            ucwords(trim(Helper::getTerbilang((int) date('Y')))),
            ['italic' => true]
        );
        $introRuns->addText(', kami dengan ini menyatakan bahwa telah dilakukan pembahasan dan penyepakatan Standar Pelayanan pada ');
        $introRuns->addText((string) $jumlahLayanan);
        $introRuns->addText(' (' . $jumlahLayananTerbilang . ') jenis pelayanan di Lingkungan ');
        $introRuns->addText($instansi->nama);
        $introRuns->addText(', sebagai berikut:');

        $section->addTextBreak(1);

        foreach ($allLayanan->values() as $index => $layanan) {
            $suffix = $index === ($jumlahLayanan - 1) ? '.' : ';';
            $section->addListItem(
                Helper::normalizeWhitespace($layanan->nama) . $suffix,
                0,
                [],
                'numbering',
                $listParagraphStyle
            );
        }

        $section->addPageBreak();

        $section->addText(
            'Demikian berita acara ini dibuat untuk digunakan sebagaimana mestinya.',
            [],
            $justifyFirstLine
        );

        $table = $section->addTable([
            'alignment' => JcTable::CENTER,
            'borderSize' => 6,
            'borderColor' => '000000'
        ]);

        $headerStyle = ['bold' => true];
        $cellCenter = ['valign' => 'center'];
        $pCenter = ['alignment' => Jc::CENTER, 'spaceBefore' => 120, 'spaceAfter' => 120];

        $table->addRow();
        $table->addCell(625, $cellCenter)->addText('No.', $headerStyle, $pCenter);
        $table->addCell(3780, $cellCenter)->addText('Nama', $headerStyle, $pCenter);
        $table->addCell(2700, $cellCenter)->addText('Jabatan', $headerStyle, $pCenter);
        $table->addCell(2340, $cellCenter)->addText('Tanda Tangan', $headerStyle, $pCenter);

        for ($i = 1; $i <= 20; $i++) {
            $table->addRow();
            $table->addCell(625, $cellCenter)->addText($i . '.', [], $pCenter);
            $table->addCell(3780, $cellCenter)->addText('', [], $pCenter);
            $table->addCell(2700, $cellCenter)->addText('', [], $pCenter);
            $table->addCell(2340, $cellCenter)->addText('', [], $pCenter);
        }

        $section->addTextBreak();
        $section->addText('Mengetahui,', [], ['alignment' => Jc::CENTER, 'spaceAfter' => 0, 'lineHeight' => 1]);
        $section->addText(
            strtoupper($standarPelayanan?->jabatan_ttd ?: 'SEKRETARIS DAERAH,'),
            [],
            ['alignment' => Jc::CENTER, 'spaceAfter' => 0, 'lineHeight' => 1]
        );
        $section->addTextBreak(4);
        $section->addText(
            $standarPelayanan?->nama_ttd ?? '',
            ['bold' => true, 'underline' => 'single'],
            ['alignment' => Jc::CENTER, 'spaceAfter' => 0, 'lineHeight' => 1]
        );

        if (!empty($standarPelayanan?->nip_ttd)) {
            $section->addText(
                'NIP. ' . $standarPelayanan->nip_ttd,
                [],
                ['alignment' => Jc::CENTER, 'spaceAfter' => 0, 'lineHeight' => 1]
            );
        }

        return $phpWord;
    }
}
