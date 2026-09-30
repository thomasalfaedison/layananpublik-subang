@php
    $jenisDokumen = $dokumenModel->jenis;
    $slug = \App\Models\Dokumen::getSlugByJenis($jenisDokumen);
    $tahun = $dokumenModel->tahun;
    $judulDokumen = \App\Models\Dokumen::getLabelByJenis($jenisDokumen);
    $breadcrumbs[] = ['label' => 'Daftar Dokumen', 'url' => $referrer];
    $breadcrumbs[] = 'Ubah ' . $judulDokumen;
@endphp

@extends(LayoutConstant::MAIN_LAYOUT)

@section('title', 'Ubah ' . $judulDokumen)

@section('content')
    @include('dokumen._form')
@endsection
