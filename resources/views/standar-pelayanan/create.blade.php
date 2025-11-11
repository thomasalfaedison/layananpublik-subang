@php
    use App\Http\Controllers\StandarPelayananController;

    $breadcrumbs[] = ['label' => 'Standar Pelayanan', 'url' => route(StandarPelayananController::ROUTE_INDEX)];
    $breadcrumbs[] = 'Tambah Standar Pelayanan';
@endphp

@extends(LayoutConstant::MAIN_LAYOUT)

@section('title', 'Tambah Standar Pelayanan')

@section('content')
    @include('standar-pelayanan._form', [
        'model' => $model,
        'referrer' => $referrer,
        'action' => $action,
    ])
@endsection
