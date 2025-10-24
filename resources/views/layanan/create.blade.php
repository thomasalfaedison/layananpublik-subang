@php
    use App\Constants\LayananConstant;

    $breadcrumbs[] = ['label' => 'Layanan', 'url' => route(LayananConstant::RouteIndex)];
    $breadcrumbs[] = 'Tambah Layanan';
@endphp

@extends(LayoutConstant::MAIN_LAYOUT)

@section('title', 'Tambah Layanan')

@section('content')
    @include('layanan._form', [
        'model' => $model,
        'referrer' => $referrer,
        'action' => route(LayananConstant::RouteCreateProcess),
    ])
@endsection

