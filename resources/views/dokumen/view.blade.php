@php
    $judulDokumen = \App\Models\Dokumen::getLabelByJenis($jenisDokumen);
    $breadcrumbs[] = $judulDokumen;
@endphp

@extends(LayoutConstant::MAIN_LAYOUT)

@section('title', $judulDokumen)

@section('content')
    @if ($jenisDokumen === \App\Models\Dokumen::JENIS_SP)
        @include('dokumen._view-standar-pelayanan', [
            'standarPelayananModel' => $standarPelayananModel,
            'dokumenModel' => $dokumenModel,
            'slug' => $slug,
        ])
    @elseif ($jenisDokumen === \App\Models\Dokumen::JENIS_BA)
        @include('dokumen._view-berita-acara', [
            'dokumenModel' => $dokumenModel,
            'slug' => $slug,
        ])
    @elseif ($jenisDokumen === \App\Models\Dokumen::JENIS_MP)
        @include('dokumen._view-maklumat-pelayanan', [
            'dokumenModel' => $dokumenModel,
            'slug' => $slug,
        ])
    @endif
@endsection
