@php
    use App\Http\Controllers\StandarPelayananController;

    $breadcrumbs[] = [
        'label' => 'Cetak SK Layanan',
        'url' => route(\App\Components\Session::isInstansi()
            ? StandarPelayananController::ROUTE_VIEW
            : StandarPelayananController::ROUTE_INDEX),
    ];
    $breadcrumbs[] = 'Ubah Pengaturan SK';
@endphp

@extends(LayoutConstant::MAIN_LAYOUT)

@section('title', 'Ubah Pengaturan SK')

@section('content')
    @include('standar-pelayanan._form', [
        'model' => $model,
        'referrer' => $referrer,
        'action' => $action,
    ])
@endsection
