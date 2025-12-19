<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Detail Layanan</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #000; }
        h2 { margin: 0 0 10px 0; }
        h3 { margin: 15px 0 8px 0; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 12px; }
        th, td { border: 1px solid #444; padding: 6px; vertical-align: top; }
        th { background: #f0f0f0; text-align: left; }
        .no-border td, .no-border th { border: 0; }
    </style>
</head>
<body>
    <h2>Detail Layanan</h2>

    <h3>Nama Layanan</h3>
    <table>
        <tr>
            <th style="width: 220px;">Perangkat Daerah</th>
            <td>{{ $model->instansi?->nama }}</td>
        </tr>
        <tr>
            <th>Nama Layanan</th>
            <td>{{ $model->nama }}</td>
        </tr>
        <tr>
            <th>Deskripsi Layanan</th>
            <td>{{ $model->deskripsi }}</td>
        </tr>
        <tr>
            <th>Persen Pengisian</th>
            <td>{{ $model->persen_komponen }}%</td>
        </tr>
    </table>

    <h3>Identitas Layanan</h3>
    <table>
        <tr>
            <th style="width: 220px;">Jenis Layanan</th>
            <td>{{ $model->layananProduk?->nama }}</td>
        </tr>
        <tr>
            <th>Pengguna Layanan</th>
            <td>{{ $model->layananPenerimaManfaat?->nama }}</td>
        </tr>
        <tr>
            <th>Jumlah Pengguna</th>
            <td>{{ $model->jumlah_pengguna }} Pengguna Per Tahun</td>
        </tr>
    </table>

    <h3>Standar Pelayanan</h3>
    @foreach ($groupLabels as $grupValue => $groupLabel)
        @php
            $allRefLayananKomponenByGroup = $allRefLayananKomponen
                ->where('grup', $grupValue)
                ->sortBy('urutan');
        @endphp

        <table>
            <tr>
                <th colspan="3">{{ $groupLabel }}</th>
            </tr>
            <tr>
                <th style="width: 40px; text-align:center">No</th>
                <th style="width: 220px;">Komponen</th>
                <th>Uraian</th>
            </tr>
            @foreach ($allRefLayananKomponenByGroup as $refKomponen)
                @php
                    $allLayananKomponenFiltered = $allLayananKomponen
                        ->where('id_ref_layanan_komponen', $refKomponen->id);
                    $jumlah = $allLayananKomponenFiltered->count();
                @endphp
                <tr>
                    <td style="text-align:center">{{ $loop->iteration }}</td>
                    <td>{{ $refKomponen->nama }}</td>
                    <td>
                        @if ($allLayananKomponenFiltered->isNotEmpty())
                            @if ($jumlah > 1)<ol style="padding-left:18px; margin:0;">@endif
                                @foreach ($allLayananKomponenFiltered as $item)
                                    @if ($jumlah > 1)<li>@endif
                                        {!! nl2br(e($item->uraian)) !!}
                                    @if ($jumlah > 1)</li>@endif
                                @endforeach
                            @if ($jumlah > 1)</ol>@endif
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @endforeach
        </table>
    @endforeach

    <h3>Survei Kepuasan Masyarakat (SKM)</h3>
    <table>
        <tr>
            <th style="width: 220px;">Dilakukan SKM?</th>
            <td>
                @if ($model->status_skm === 1)
                    Ya
                @elseif($model->status_skm === 0)
                    Tidak
                @endif
            </td>
        </tr>
        <tr>
            <th>Nilai SKM Terakhir</th>
            <td>{{ $model->nilai_skm }}</td>
        </tr>
    </table>

    <h3>Digitalisasi dan Inovasi</h3>
    <table>
        <tr>
            <th style="width: 220px;">Status Digitalisasi</th>
            <td>
                @if ($model->status_digitalisasi == 1)
                    Manual
                @elseif ($model->status_digitalisasi == 2)
                    Semi Digital
                @elseif ($model->status_digitalisasi == 3)
                    Full Online
                @endif
            </td>
        </tr>
        <tr>
            <th>Nama Aplikasi</th>
            <td>{{ $model->nama_aplikasi }}</td>
        </tr>
        <tr>
            <th>Link Aplikasi</th>
            <td>{{ $model->link_aplikasi }}</td>
        </tr>
        <tr>
            <th>Apakah Ada Inovasi?</th>
            <td>
                @if ($model->status_inovasi === 1)
                    Ada
                @elseif ($model->status_inovasi === 0)
                    Tidak Ada
                @endif
            </td>
        </tr>
        <tr>
            <th>Deskripsi Inovasi</th>
            <td>{{ $model->deskripsi_inovasi }}</td>
        </tr>
    </table>
</body>
</html>
