<?php

namespace App\Services;

use App\Components\Helper;
use App\Components\Html;
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

    public function streamWordMaklumatPelayanan(array $params = [])
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

        $phpWord = $this->buildMaklumatPelayananDocument([
            'instansi' => $instansi,
            'standarPelayanan' => $standarPelayanan,
        ]);

        $tmpBase = tempnam(sys_get_temp_dir(), 'mp-sp-');
        $tmpFile = $tmpBase . '.docx';

        if ($tmpBase !== false && file_exists($tmpBase)) {
            @unlink($tmpBase);
        }

        $writer = IOFactory::createWriter($phpWord, 'Word2007');
        $writer->save($tmpFile);

        $filename = sprintf(
            'maklumat-pelayanan-%s.docx',
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
            'paperSize' => 'Legal',
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
                Helper::normalizeWhitespace($this->cleanText($layanan->nama)) . $suffix,
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

    protected function buildMaklumatPelayananDocument(array $payload): PhpWord
    {
        $instansi = $payload['instansi'];
        $standarPelayanan = $payload['standarPelayanan'];

        $phpWord = new PhpWord();
        $phpWord->setDefaultFontName('Bookman Old Style');
        $phpWord->setDefaultFontSize(12);
        $phpWord->addNumberingStyle(
            'maklumat-decimal-list',
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
        $phpWord->addNumberingStyle(
            'maklumat-alpha-list',
            [
                'type' => 'multilevel',
                'levels' => [
                    [
                        'format' => 'lowerLetter',
                        'text' => '%1.',
                        'left' => 450,
                        'hanging' => 450,
                    ],
                ],
            ]
        );

        $section = $phpWord->addSection([
            'marginTop' => 900,
            'marginRight' => 900,
            'marginBottom' => 900,
            'marginLeft' => 900,
            'paperSize' => 'Legal',
        ]);

        $headerTitleStyle = [
            'bold' => true,
            'name' => 'Bookman Old Style',
            'size' => 17,
        ];

        $headerSubtitleStyle = [
            'bold' => true,
            'name' => 'Bookman Old Style',
            'size' => 24,
        ];

        $titleStyle = [
            'bold' => false,
            'name' => 'Bookman Old Style',
            'size' => 12,
        ];

        $smallStyle = [
            'name' => 'Bookman Old Style',
            'size' => 10.5,
        ];

        $signatureNameStyle = [
            'bold' => true,
            'underline' => 'single',
            'name' => 'Bookman Old Style',
            'size' => 12,
        ];

        $centerParagraph = [
            'alignment' => Jc::CENTER,
            'spaceAfter' => 0,
            'lineHeight' => 1,
        ];

        $bodyParagraph = [
            'alignment' => Jc::BOTH,
            'lineHeight' => 1,
            'spaceAfter' => 0,
        ];

        $maklumatQuoteParagraph = array_merge($bodyParagraph, ['spaceBefore' => 120]);

        $headerTable = $section->addTable([
            'width' => 100 * 50,
            'unit' => 'pct',
            'alignment' => JcTable::CENTER,
            'borderSize' => 0,
            'borderColor' => 'FFFFFF',
            'cellMarginTop' => 0,
            'cellMarginBottom' => 0,
            'cellMarginLeft' => 0,
            'cellMarginRight' => 0,
        ]);

        $headerTable->addRow();
        $logoCell = $headerTable->addCell(1100, [
            'valign' => 'top',
            'borderSize' => 0,
            'borderColor' => 'FFFFFF',
        ]);
        $logoPath = public_path('images/logo.png');
        if (file_exists($logoPath)) {
            $logoCell->addImage($logoPath, [
                'width' => 75,
                'height' => 75,
                'alignment' => Jc::CENTER,
            ]);
        }

        $headerTextCell = $headerTable->addCell(8300, [
            'valign' => 'center',
            'borderSize' => 0,
            'borderColor' => 'FFFFFF',
        ]);

        $headerTextCell->addText('PEMERINTAH DAERAH KABUPATEN SUBANG', $headerTitleStyle, $centerParagraph);
        $headerTextCell->addText(strtoupper($instansi->nama), $headerSubtitleStyle, $centerParagraph);
        $headerTextCell->addText(Helper::normalizeWhitespace($standarPelayanan?->alamat), $smallStyle, $centerParagraph);

        $section->addText(
            '',
            [],
            [
                'borderBottomSize' => 12,
                'borderBottomColor' => '000000',
            ]
        );

        $section->addTextBreak(1);
        $section->addText(
            'KEPUTUSAN ' . $this->buildJudul($standarPelayanan?->jabatan_ttd, $instansi),
            $titleStyle,
            $centerParagraph
        );
        $section->addText(
            'NOMOR : ' . ($standarPelayanan?->nomor ?: '........................................'),
            $titleStyle,
            $centerParagraph
        );
        $section->addTextBreak(1);
        $section->addText('TENTANG', $titleStyle, $centerParagraph);
        $section->addTextBreak(1);
        $section->addText('MAKLUMAT PELAYANAN', $titleStyle, $centerParagraph);
        $section->addText(
            'PADA ' . strtoupper($instansi->nama) . ' KABUPATEN SUBANG',
            $titleStyle,
            $centerParagraph
        );
        $section->addTextBreak(1);
        $section->addText(
            $this->buildJudul($standarPelayanan?->jabatan_ttd, $instansi) . ',',
            $titleStyle,
            $centerParagraph
        );
        $section->addTextBreak(1);

        $bodyTable = $section->addTable([
            'width' => 100 * 50,
            'unit' => 'pct',
            'alignment' => JcTable::START,
            'borderSize' => 0,
            'borderColor' => 'FFFFFF',
            'cellMarginTop' => 0,
            'cellMarginBottom' => 0,
            'cellMarginLeft' => 0,
            'cellMarginRight' => 0,
        ]);

        $bodyTable->addRow();
        $bodyTable->addCell(1700)->addText('Menimbang', $titleStyle, $bodyParagraph);
        $bodyTable->addCell(300)->addText(':', $titleStyle, $centerParagraph);
        $menimbangCell = $bodyTable->addCell(7400);
        $menimbangCell->addListItem(
            'bahwa Standar Pelayanan pada ' . $instansi->nama . ' Kabupaten Subang telah ditetapkan dengan Keputusan ' .
            ($standarPelayanan?->jabatan_ttd ?: 'Kepala Instansi') . ' Kabupaten Subang Nomor ' .
            ($standarPelayanan?->nomor ?: '........................................') . ';',
            0,
            $titleStyle,
            'maklumat-alpha-list',
            $bodyParagraph
        );
        $menimbangCell->addListItem(
            'bahwa untuk memberikan janji pelayanan terhadap seluruh pengguna layanan, maka perlu dibuat maklumat pelayanan pada ' .
            $instansi->nama . ' Kabupaten Subang dengan Keputusan ' .
            ($standarPelayanan?->jabatan_ttd ?: 'Kepala Instansi') . ' Kabupaten Subang;',
            0,
            $titleStyle,
            'maklumat-alpha-list',
            $bodyParagraph
        );

        $bodyTable->addRow();
        $bodyTable->addCell(1700)->addText('Mengingat', $titleStyle, $bodyParagraph);
        $bodyTable->addCell(300)->addText(':', $titleStyle, $centerParagraph);
        $mengingatCell = $bodyTable->addCell(7400);

        foreach ($this->getListReferensiHukum() as $reference) {
            $mengingatCell->addListItem(
                $reference,
                0,
                $titleStyle,
                'maklumat-decimal-list',
                $bodyParagraph
            );
        }

        $section->addTextBreak(1);
        $section->addText('MEMUTUSKAN :', $titleStyle, $centerParagraph);
        $section->addTextBreak(1);

        $decisionTable = $section->addTable([
            'width' => 100 * 50,
            'unit' => 'pct',
            'alignment' => JcTable::START,
            'borderSize' => 0,
            'borderColor' => 'FFFFFF',
            'cellMarginTop' => 0,
            'cellMarginBottom' => 0,
            'cellMarginLeft' => 0,
            'cellMarginRight' => 0,
        ]);

        $decisionTable->addRow();
        $decisionTable->addCell(1700)->addText('Menetapkan', $titleStyle, $bodyParagraph);
        $decisionTable->addCell(300)->addText(':', $titleStyle, $centerParagraph);
        $decisionTable->addCell(7400)->addText('', $titleStyle, $bodyParagraph);

        $decisionTable->addRow();
        $decisionTable->addCell(1700)->addText('KESATU', $titleStyle, $bodyParagraph);
        $decisionTable->addCell(300)->addText(':', $titleStyle, $centerParagraph);
        $decisionTable->addCell(7400)->addText(
            'Maklumat Pelayanan pada ' . $instansi->nama . ' Kabupaten Subang.',
            $titleStyle,
            $bodyParagraph
        );

        $decisionTable->addRow();
        $decisionTable->addCell(1700)->addText('KEDUA', $titleStyle, $bodyParagraph);
        $decisionTable->addCell(300)->addText(':', $titleStyle, $centerParagraph);
        $keduaCell = $decisionTable->addCell(7400);
        $keduaCell->addText(
            'Maklumat Pelayanan pada ' . $instansi->nama . ' Kabupaten Subang adalah sebagai berikut :',
            $titleStyle,
            $bodyParagraph
        );
        $keduaCell->addText(
            '“DENGAN INI KAMI MENYATAKAN SANGGUP MENYELENGGARAKAN PELAYANAN SESUAI STANDAR PELAYANAN YANG TELAH DITETAPKAN, APABILA TIDAK MEMENUHI JANJI INI KAMI BERSEDIA MENERIMA SANKSI SESUAI DENGAN KETENTUAN PERATURAN PERUNDANG-UNDANGAN YANG BERLAKU”',
            $titleStyle,
            $maklumatQuoteParagraph
        );

        $decisionTable->addRow();
        $decisionTable->addCell(1700)->addText('KETIGA', $titleStyle, $bodyParagraph);
        $decisionTable->addCell(300)->addText(':', $titleStyle, $centerParagraph);
        $decisionTable->addCell(7400)->addText(
            'Keputusan ' . ($standarPelayanan?->jabatan_ttd ?: 'Sekretaris Daerah') . ' ini mulai berlaku pada tanggal ditetapkan.',
            $titleStyle,
            $bodyParagraph
        );

        $section->addTextBreak(1);

        $signatureTable = $section->addTable([
            'width' => 100 * 50,
            'unit' => 'pct',
            'alignment' => JcTable::END,
            'borderSize' => 0,
            'borderColor' => 'FFFFFF',
            'cellMarginTop' => 0,
            'cellMarginBottom' => 0,
            'cellMarginLeft' => 0,
            'cellMarginRight' => 0,
        ]);

        $signatureTable->addRow();
        $signatureTable->addCell(4700)->addText('', [], $bodyParagraph);
        $signatureCell = $signatureTable->addCell(4700);
        $signatureCell->addText('Ditetapkan di Subang', $titleStyle, $bodyParagraph);
        $signatureCell->addText(
            'pada tanggal ' . Helper::getTanggal(date('Y-m-d')),
            $titleStyle,
            array_merge($bodyParagraph, ['spaceAfter' => 120]),
        );
        $signatureCell->addText(
            $this->buildJudulTandatangan($standarPelayanan?->jabatan_ttd, $instansi),
            $titleStyle,
            $centerParagraph
        );
        $signatureCell->addTextBreak(3);
        $signatureCell->addText(
            $standarPelayanan?->nama_ttd ?? '',
            $signatureNameStyle,
            $centerParagraph
        );

        $nipTtd = $standarPelayanan?->nip_ttd ? 'NIP. ' . $standarPelayanan?->nip_ttd : '';

        $signatureCell->addText(
            $nipTtd,
            $titleStyle,
            $centerParagraph
        );

        return $phpWord;
    }

    protected function getListReferensiHukum(): array
    {
        return [
            'Undang-Undang Nomor 14 Tahun 1950 tentang Pembentukan Daerah-Daerah Kabupaten Dalam Lingkungan Propinsi Djawa Barat (Berita Negara Republik Indonesia Tahun 1950), sebagaimana telah diubah dengan Undang-Undang Nomor 4 Tahun 1968 tentang Pembentukan Kabupaten Purwakarta dan Kabupaten Subang, dengan Mengubah Undang-Undang Nomor 14 Tahun 1950 tentang Pembentukan Daerah-Daerah Kabupaten Dalam Lingkungan Propinsi Djawa Barat (Lembaran Negara Republik Indonesia Tahun 1968 Nomor 31, Tambahan Lembaran Negara Republik Indonesia Nomor 2851);',
            'Undang-Undang Nomor 25 Tahun 2009 tentang Pelayanan Publik (Lembaran Negara Republik Indonesia Tahun 2009 Nomor 112, Tambahan Lembaran Negara Republik Indonesia Nomor 5038);',
            'Undang-Undang Nomor 23 Tahun 2014 tentang Pemerintahan Daerah (Lembaran Negara Republik Indonesia Tahun 2014 Nomor 244, Tambahan Lembaran Negara Republik Indonesia Nomor 5587), sebagaimana telah diubah beberapa kali terakhir dengan Undang-Undang Nomor 9 Tahun 2015 tentang Perubahan Kedua Atas Undang-Undang Nomor 23 Tahun 2014 tentang Pemerintahan Daerah (Lembaran Negara Republik Indonesia Tahun 2015 Nomor 58, Tambahan Lembaran Negara Republik Indonesia Nomor 5679);',
            'Undang-Undang Nomor 30 Tahun 2014 tentang Administrasi Pemerintahan (Lembaran Negara Republik Indonesia Tahun 2014 Nomor 292, Tambahan Lembaran Negara Republik Indonesia Nomor 5601);',
            'Peraturan Pemerintah Nomor 96 Tahun 2012 tentang Pelaksanaan Undang-Undang Nomor 25 Tahun 2009 tentang Pelayanan Publik (Lembaran Negara Republik Indonesia Tahun 2012 Nomor 215, Tambahan Lembaran Negara Republik Indonesia Nomor 5357);',
            'Peraturan Menteri Pendayagunaan Aparatur Negara dan Reformasi Birokrasi Nomor 15 Tahun 2014 tentang Pedoman Standar Pelayanan (Berita Negara Republik Indonesia Tahun 2014 Nomor 615);',
            'Peraturan Daerah Kabupaten Subang Nomor 7 Tahun 2016 tentang Pembentukan dan Susunan Perangkat Daerah Kabupaten Subang (Lembaran Daerah Kabupaten Subang Tahun 2016 Nomor 7), sebagaimana telah diubah beberapa kali terakhir dengan Peraturan Daerah Kabupaten Subang Nomor 1 Tahun 2021 tentang Perubahan Ketiga Atas Peraturan Daerah Kabupaten Subang Nomor 7 Tahun 2016 tentang Pembentukan dan Susunan Perangkat Daerah Kabupaten Subang (Lembaran Daerah Kabupaten Subang Tahun 2021 Nomor 1);',
        ];
    }

    protected function buildJudul(?string $nama_jabatan, $instansi): string
    {
        $nama_jabatan = strtoupper($nama_jabatan ?: ('KEPALA ' . $instansi->nama));

        if (str_contains($nama_jabatan, 'KABUPATEN SUBANG')) {
            return $nama_jabatan;
        }

        return trim($nama_jabatan . ' KABUPATEN SUBANG');
    }

    protected function buildJudulTandatangan(?string $jabatan, $instansi): string
    {
        return $this->buildJudul($jabatan ?: 'SEKRETARIS DAERAH', $instansi);
    }

    protected function cleanText(?string $text)
    {
        if ($text === null) return null;
        
        $text = htmlspecialchars($text); 
        $text = strip_tags($text);
        
        return trim($text);
    }
}
