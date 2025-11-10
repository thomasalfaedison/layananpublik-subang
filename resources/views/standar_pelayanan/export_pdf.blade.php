<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<style>
    @page { margin: 1.8cm 2.2cm; }
    body {
        font-family: "Times New Roman", serif;
        font-size: 11pt;
        line-height: 1.5;
        color: #000;
    }

    /* Header Kop Surat */
    .kop {
        text-align: center;
        margin-bottom: 10px;
        position: relative;
    }

    .kop img {
        position: absolute;
        top: 0;
        left: 0;
        width: 90px;
        height: auto;
    }

    .kop h1 {
        font-size: 18pt;
        margin: 0;
        font-weight: bold;
    }

    .kop h2 {
        font-size: 40pt;
        margin: 0;
        font-weight: bold;
        letter-spacing: 1px;
        margin-top: -20px;
    }

    .kop p {
        margin: 0;
        margin-top: -6px;
        font-size: 11pt;
        letter-spacing: 1px;
    }

    .line {
        border-top: 1px solid #000;
        border-bottom: 2px solid #000;
        height: 4px;
        margin-top: 8px;
        margin-bottom: 15px;
    }

    /* Judul Surat */
    .judul {
        text-align: center;
        font-weight: bold;
        margin-top: 4px;
        margin-bottom: 8px;
        page-break-inside: avoid;
    }

    .judul .nomor {
        margin-top: 4px;
        margin-bottom: 10px;
    }

    /* Layout bagian isi (Menimbang, Mengingat) */
    .row {
        display: table;
        width: 100%;
        margin-bottom: 10px;
        page-break-inside: avoid;
    }

    .cell {
        display: table-cell;
        vertical-align: top;
    }

    .label {
        width: 90px;
        white-space: nowrap;
    }

    .colon {
        width: 10px;
    }

    .isi {
        text-align: justify;
    }

    ol {
        margin-top: 0;
        padding-left: 20px;
    }

</style>
</head>
<body>

<div class="kop">
    <img src="/public/images/logo.png" alt="Logo">
    <h1>PEMERINTAH KABUPATEN SUBANG</h1>
    <h2>DINAS SOSIAL</h2>
    <p>Jl. D.I. Panjaitan No. 81 Telp./Fax. (0260) 411425 Subang</p>
    <div class="line"></div>
</div>

<div class="judul">
    <p>KEPUTUSAN KEPALA DINAS SOSIAL KABUPATEN SUBANG</p>
    <p class="nomor">NOMOR : 58.06 / 1234 / DS</p>
    <p>TENTANG</p>
    <p>STANDAR PELAYANAN<br>DI DINAS SOSIAL KABUPATEN SUBANG</p>
    <p>KEPALA DINAS SOSIAL KABUPATEN SUBANG</p>
</div>

<div class="row">
    <div class="cell label">Menimbang</div>
    <div class="cell colon">:</div>
    <div class="cell isi">
        bahwa dalam rangka mewujudkan penyelenggaraan pelayanan publik sesuai dengan asas penyelenggaraan pemerintahan yang baik dan guna mewujudkan kepastian hak dan kewajiban berbagai pihak yang terkait dengan penyelenggaraan pelayanan, setiap penyelenggaraan pelayanan publik wajib menetapkan Standar Pelayanan;
    </div>
</div>

<div class="row">
    <div class="cell label">Mengingat</div>
    <div class="cell colon">:</div>
    <div class="cell isi">
        <ol type="1">
            <li>Undang-Undang Nomor 14 Tahun 1950 tentang Pembentukan Daerah-Daerah Kabupaten Dalam Lingkungan Propinsi Djawa Barat (Berita Negara Republik Indonesia Tahun 1950), sebagaimana telah diubah dengan Undang-Undang Nomor 4 Tahun 1968 tentang Pembentukan Kabupaten Purwakarta dan Kabupaten Subang, dengan Mengubah Undang-Undang Nomor 14 Tahun 1950 tentang Pembentukan Daerah-Daerah Kabupaten Dalam Lingkungan Propinsi Djawa Barat (Lembaran Negara Republik Indonesia Tahun 1968 Nomor 31, Tambahan Lembaran Negara Republik Indonesia Nomor 2851);</li>
            <li>Undang-Undang Nomor 25 Tahun 2009 tentang Pelayanan Publik (Lembaran Negara Republik Indonesia Tahun 2009 Nomor 112, Tambahan Lembaran Negara Republik Indonesia Nomor 5038);</li>
            <li>Undang-Undang Nomor 23 Tahun 2014 tentang Pemerintahan Daerah (Lembaran Negara Republik Indonesia Tahun 2014 Nomor 244, Tambahan Lembaran Negara Republik Indonesia Nomor 5587), sebagaimana telah diubah beberapa kali terakhir dengan Undang-Undang Nomor 9 Tahun 2015 tentang Perubahan Kedua atas Undang-Undang Nomor 23 Tahun 2014 tentang Pemerintahan Daerah (Lembaran Negara Republik Indonesia Tahun 2015 Nomor 58, Tambahan Lembaran Negara Republik Indonesia Nomor 5679);</li>
        </ol>
    </div>
</div>

</body>
</html>
