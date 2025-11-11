<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<style>
    @page { margin: 12mm 10mm; }
    body {
        font-family: sans-serif;
        font-size: 11pt;
        color: #000;
    }

    /* Header Kop Surat */
    .kop {
        text-align: center;
        margin-bottom: 10px;
    }

    .kop img {
        top: 0;
        left: 0;
        width: 110px;
        height: auto;
    }

    .kop .judul {
        font-size: 20pt;
        font-weight: bold;
    }

    .kop .nama-instansi {
        font-size: 46pt;
        font-weight: bold;
    }

    .line {
        border-top: 1px solid #000;
        border-bottom: 2px solid #000;
        height: 4px;
        margin-top: 8px;
        margin-bottom: 15px;
    }

    ol {
        margin-top: 0;
        padding-left: 20px;
    }

    .table-bordered {
        width: 100%;
        border-collapse: collapse;
    }

    .table-bordered th, .table-bordered td { 
        border: 1px solid #000;
        vertical-align: top;
        padding: 6px;
        font-size: 13px;
    }

    .table {
        width: 100%;
    }

    .table th, .table td {
        vertical-align: top;
    }

    .table-bordered th {
        text-transform: uppercase;
    }

    .page-break {
        page-break-before: always;
    }

</style>
</head>
<body>

@php
    $instansiNama = optional($instansi)->nama ?? '';
    $standarNomor = optional($standarPelayanan)->nomor;
    $alamatKantor = trim(optional($standarPelayanan)->alamat ?? (optional($instansi)->alamat ?? ''));
    $alamatKantor = $alamatKantor !== '' ? $alamatKantor : 'Jl. D.I. Panjaitan No. 81 Telp./Fax. (0260) 411425 Subang';
    $jabatanTTD = optional($standarPelayanan)->jabatan_ttd ?: ('Kepala ' . $instansiNama);
    $namaTTD = optional($standarPelayanan)->nama_ttd;
    $nipTTD = optional($standarPelayanan)->nip_ttd;
    $kotaInstansi = optional($instansi)->kota ?? 'Subang';
@endphp

<div class="kop">
    <table style="margin-left: auto; margin-right: auto; width:100%">
        <tr>
            <td style="text-align: center">
                <img src="/public/images/logo.png" alt="Logo">
            </td>
            <td style="text-align: center">
                <div class="judul">PEMERINTAH KABUPATEN SUBANG</div>
                @php
                    $len = strlen($instansi->nama);

                    // maksimal font 46pt, minimal 18pt
                    $fontSize = max(18, min(46, 140 / sqrt($len))); 
                @endphp
                <div class="nama-instansi" style="line-height: 1.1; font-size: {{ $fontSize }}pt;">
                    {{ strtoupper($instansi->nama) }}
                </div>
                <div style="font-weight: bold">{{ $alamatKantor }}</div>
            </td>
        </tr>
    </table>
    <div class="line"></div>
</div>

<div style="text-align: center;">
    <div>KEPUTUSAN KEPALA {{ strtoupper($instansi->nama) }} KABUPATEN SUBANG</div>
    <div>NOMOR : {{ $standarNomor ?? '.......................' }}</div>
    <div style="margin-top: 30px; margin-bottom: 20px;">TENTANG</div>
    <div>STANDAR PELAYANAN<br>DI {{ strtoupper($instansi->nama) }} KABUPATEN SUBANG</div>
    <p>KEPALA {{ strtoupper($instansi->nama) }} KABUPATEN SUBANG</p>
</div>

<table class="table">
    <tr>
        <td style="width: 120px;">
            Menimbang
        </td>
        <td style="width: 10px;">:</td>
        <td>
            bahwa dalam rangka mewujudkan penyelenggaraan pelayanan publik sesuai dengan asas penyelenggaraan pemerintahan yang baik dan guna mewujudkan
            kepastian hak dan kewajiban berbagai pihak yang terkait dengan penyelenggaraan pelayanan, setiap penyelenggaraan pelayanan publik wajib menetapkan
            Standar Pelayanan;
        </td>
    </tr>
    <td>
        <td colspan="3" style="height: 10px;"></td>
    </td>
    <tr>
        <td>
            Mengingat
        </td>
        <td>:</td>
        <td>
            <ol start="1" style="margin: 0;">
                <li>
                    Undang-Undang Nomor 14 Tahun 1950 tentang Pembentukan Daerah-Daerah Kabupaten Dalam Lingkungan Propinsi Djawa Barat
                    (Berita Negara Republik Indonesia Tahun 1950), sebagaimana telah diubah dengan Undang-Undang Nomor 4 Tahun 1968 tentang Pembentukan
                    Kabupaten Purwakarta dan Kabupaten Subang, dengan Mengubah Undang-Undang Nomor 14 Tahun 1950 tentang Pembentukan Daerah-Daerah Kabupaten
                    Dalam Lingkungan Propinsi Djawa Barat (Lembaran Negara Republik Indonesia Tahun 1968 Nomor 31, Tambahan Lembaran Negara Republik
                    Indonesia Nomor 2851);
                </li>
            </ol>
        </td>
    </tr>
    <tr>
        <td colspan="2"></td>
        <td>
            <ol start="2" style="margin: 0;">
                <li>
                    Undang-Undang Nomor 25 Tahun 2009 tentang Pelayanan Publik (Lembaran Negara Republik Indonesia Tahun 2009 Nomor
                    112, Tambahan Lembaran Negara Republik Indonesia Nomor 5038);
                </li>
            </ol>
        </td>
    </tr>
    <tr>
        <td colspan="2"></td>
        <td>
            <ol start="3" style="margin: 0;">
                <li>
                    Undang-Undang Nomor 23 Tahun 2014 tentang Pemerintahan Daerah (Lembaran Negara Republik Indonesia Tahun 2014 Nomor 244, Tambahan Lembaran
                    Negara Republik Indonesia Nomor 5587), sebagaimana telah diubah beberapa kali terakhir dengan Undang-Undang Nomor 9 Tahun 2015 tentang
                    Perubahan Kedua atas Undang-Undang Nomor 23 Tahun 2014 tentang Pemerintahan Daerah (Lembaran Negara Republik Indonesia Tahun 2015 Nomor 58,
                    Tambahan Lembaran Negara Republik Indonesia Nomor 5679);
                </li>
            </ol>
        </td>
    </tr>
    <tr>
        <td colspan="2"></td>
        <td>
            <ol start="4" style="margin: 0;">
                <li>
                    Undang-Undang Nomor 30 Tahun 2014 tentang Administrasi Pemerintahan (Lembaran Negara Republik Indonesia Tahun 2014 Nomor 292, Tambahan
                    Lembaran Negara Republik Indonesia Nomor 5601);
                </li>
            </ol>
        </td>
    </tr>
    <tr>
        <td colspan="2"></td>
        <td>
            <ol start="5" style="margin: 0;">
                <li>
                    Peraturan Pemerintah Nomor 96 Tahun 2012 tentang Pelaksanaan Undang-Undang Nomor 25 Tahun 2009 tentang Pelayanan Publik (Lembaran Negara
                    Republik Indonesia Tahun 2012 Nomor 215, Tambahan Lembaran Negara Republik Indonesia Nomor 5357);
                </li>
            </ol>
        </td>
    </tr>
    <tr>
        <td colspan="2"></td>
        <td>
            <ol start="6" style="margin: 0;">
                <li>
                    Peraturan Menteri Pendayagunaan Aparatur Negara dan Reformasi Birokrasi Nomor 15 Tahun 2014 tentang Pedoman Standar Pelayanan
                    (Berita Negara Republik Indonesia Tahun 2014 Nomor 615);
                </li>
            </ol>
        </td>
    </tr>
    <tr>
        <td colspan="2"></td>
        <td>
            <ol start="7" style="margin: 0;">
                <li>
                    Peraturan Daerah Kabupaten Subang Nomor 7 Tahun 2016 tentang Pembentukan dan Susunan Perangkat Daerah Kabupaten Subang (Lembaran Daerah
                    Kabupaten Subang Tahun 2016 Nomor 7), sebagaimana yang telah diubah beberapa kali terakhir dengan Peraturan Daerah Kabupaten Subang
                    Nomor 1 Tahun 2021 tentang Perubahan Ketiga Atas Peraturan Daerah Kabupaten Subang Nomor 7 Tahun 2016 tentang Pembentukan dan
                    Susunan Perangkat Daerah Kabupaten Subang (Lembaran Daerah Kabupaten Subang Tahun 2021 Nomor 1);
                </li>
            </ol>
        </td>
    </tr>
</table>

<div style="margin-top: 20px; text-align: center;">MEMUTUSKAN</div>

<table class="table" style="margin-top: 20px;">
    <tr>
        <td style="width: 120px;">Menetapkan</td>
        <td style="width: 10px;">:</td>
        <td> </td>
    </tr>

    <tr>
        <td style="vertical-align: top;">KESATU</td>
        <td style="vertical-align: top;">:</td>
        <td>
            Standar Pelayanan di {{ $instansi->nama }} Kabupaten Subang sebanyak 7 (tujuh) jenis layanan.
        </td>
    </tr>

    <tr>
        <td style="vertical-align: top;">KEDUA</td>
        <td style="vertical-align: top;">:</td>
        <td>
            Standar Pelayanan tersebut adalah sebagai berikut:
            <ol style="margin: 6px 0 0 18px; padding: 0;">
                <li>Standar Pelayanan Kartu Indonesia Sehat;</li>
                <li>Standar Pelayanan PKH;</li>
                <li>Standar Pelayanan Kartu Indonesia Pintar;</li>
                <li>Standar Pelayanan Bantuan Sosial Tunai;</li>
                <li>Standar Pelayanan Rutilahu;</li>
                <li>Standar Pelayanan Bantuan Pangan Non-Tunai;</li>
                <li>Standar Pelayanan Bantuan Sosial Kerumah Sakit Ciereng.</li>
            </ol>
        </td>
    </tr>

    <tr>
        <td style="vertical-align: top;">KETIGA</td>
        <td style="vertical-align: top;">:</td>
        <td>
            Keputusan Kepala Dinas ini mulai berlaku pada tanggal ditetapkan.
        </td>
    </tr>
</table>

<div style="margin-top: 36px; width: 50%; float: right; text-align: center;">
    <div>Ditetapkan di : {{ strtoupper($kotaInstansi) }}</div>
    <div>pada tanggal : <u></u></div>

    <div style="margin-top: 30px; font-weight: bold;">
        {{ strtoupper($jabatanTTD) }}
    </div>

    <div style="height: 70px;"></div>
    <div style="text-decoration: underline; font-weight: bold;">
        {{ $namaTTD ?? '' }}
    </div>
    <div>NIP. {{ $nipTTD ?? '' }}</div>
</div>

<div style="clear: both;"></div>
<!-- AKHIR BLOK -->


@if ($allLayanan->isNotEmpty())    
    <div class="page-break"></div>

    @foreach ($allLayanan as $layanan)
        <div style="text-transform: uppercase;">
            {{ $loop->iteration }}.
            <span style="margin-left: 5px;">{{ $layanan->nama }}</span>
        </div>

        <div style="margin-left: 22px; margin-top: 10px;">
            @foreach ($listGrupLabel as $grup => $label)
                <div style="margin-bottom: 10px;">
                    {{ $label }}
                </div>
                @include('standar-pelayanan._table-layanan-komponen', [
                    'allLayananKomponen' => $allLayananKomponen->where('id_layanan', $layanan->id),
                    'listRefLayananKomponen' => $listRefLayananKomponen->where('grup', $grup),
                ])
                <div style="margin-bottom: 10px;"></div>
            @endforeach
        </div>
        <div style="margin-bottom: 25px;"></div>
    @endforeach
@endif

</body>
</html>
