@php
    $judulDokumen = \App\Models\Dokumen::getLabelByJenis($jenisDokumen);
    $breadcrumbs[] = ['label' => 'Daftar Dokumen', 'url' => $referrer];
    $breadcrumbs[] = 'Unggah ' . $judulDokumen;
@endphp

@extends(LayoutConstant::MAIN_LAYOUT)

@section('title', 'Unggah ' . $judulDokumen)

@section('content')
    @include('dokumen._form', [
        'jenisDokumen' => $jenisDokumen,
        'slug' => $slug,
        'listInstansiDokumen' => $listInstansiDokumen,
        'referrer' => $referrer,
    ])
@endsection
