@php
    use App\Constants\LayananConstant;

    $breadcrumbs[] = ['label' => 'Layanan', 'url' => route(LayananConstant::RouteIndex)];
    $breadcrumbs[] = 'Ubah Layanan';
@endphp

@extends(LayoutConstant::MAIN_LAYOUT)

@section('title', 'Ubah Layanan')

@section('content')
    @include('layanan._form', [
        'model' => $model,
        'referrer' => $referrer,
        'action' => route(LayananConstant::RouteUpdateProcess, ['id' => $model->id]),
    ])
@endsection

