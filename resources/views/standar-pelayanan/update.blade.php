@php
    use App\Http\Controllers\StandarPelayananController;

    $breadcrumbs[] = ['label' => 'Standar Pelayanan', 'url' => route(StandarPelayananController::ROUTE_INDEX)];
    $breadcrumbs[] = 'Ubah Standar Pelayanan';
@endphp

@extends(LayoutConstant::MAIN_LAYOUT)

@section('title', 'Ubah Standar Pelayanan')

@section('content')
    @include('standar-pelayanan._form', [
        'model' => $model,
        'referrer' => $referrer,
        'action' => $action,
    ])
@endsection
