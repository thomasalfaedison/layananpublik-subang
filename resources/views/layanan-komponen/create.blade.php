@php
    use App\Constants\LayananKomponenConstant;

    $breadcrumbs[] = ['label' => 'Komponen Layanan', 'url' => route(LayananKomponenConstant::RouteIndex)];
    $breadcrumbs[] = 'Tambah Komponen';
@endphp

@extends(LayoutConstant::MAIN_LAYOUT)

@section('title', 'Tambah Komponen Layanan')

@section('content')
    @include('layanan-komponen._form', [
        'model' => $model,
        'referrer' => $referrer,
        'action' => route(LayananKomponenConstant::RouteCreateProcess, request()->query()),
    ])
@endsection

