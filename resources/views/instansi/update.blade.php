@php
    use App\Constants\InstansiConstant;

    $breadcrumbs[] = ['label' => 'Perangkat Daerah', 'url' => route(InstansiConstant::RouteIndex)];
    $breadcrumbs[] = 'Ubah Perangkat Daerah';
@endphp

@extends(LayoutConstant::MAIN_LAYOUT)

@section('title', 'Ubah Perangkat Daerah')
    
@section('content')
    @include('instansi._form', [
        'model' => $model,
        'referrer' => $referrer,
        'action' => route(InstansiConstant::RouteUpdateProcess,['id' => $model->id]),
    ])
@endsection