@php
    use App\Constants\InstansiConstant;
    
    $breadcrumbs[] = ['label' => 'Perangkat Daerah', 'url' => route(InstansiConstant::RouteIndex)];
    $breadcrumbs[] = 'Tambah Perangkat Daerah';
@endphp

@extends(LayoutConstant::MAIN_LAYOUT)

@section('title', 'Tambah Perangkat Daerah')
    
@section('content')
    @include('instansi._form', [
        'model' => $model,
        'referrer' => $referrer,
        'action' => route(InstansiConstant::RouteCreateProcess),
    ])
@endsection