@php
    use App\Http\Controllers\InstansiController;

    $judulDokumen = [
        \App\Models\Dokumen::JENIS_SP => 'Standar Pelayanan',
        \App\Models\Dokumen::JENIS_BA => 'Berita Acara',
        \App\Models\Dokumen::JENIS_MP => 'Maklumat Pelayanan',
    ][$jenisDokumen] ?? 'Dokumen';

    $breadcrumbs[] = ['label' => 'Daftar Dokumen', 'url' => $referrer];
    $breadcrumbs[] = 'Unggah ' . $judulDokumen;
@endphp

@extends(LayoutConstant::MAIN_LAYOUT)

@section('title', 'Unggah ' . $judulDokumen)

@section('content')
    @include('instansi._form-upload-dokumen', [
        'jenisDokumen' => $jenisDokumen,
        'listInstansiDokumen' => $listInstansiDokumen,
        'referrer' => $referrer,
    ])
@endsection
