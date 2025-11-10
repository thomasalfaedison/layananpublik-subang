@php
    use App\Constants\LayananKomponenConstant;

    $breadcrumbs[] = ['label' => 'Komponen Layanan', 'url' => route(LayananKomponenConstant::RouteIndex)];
    $breadcrumbs[] = 'Ubah Komponen';
@endphp

@extends(LayoutConstant::MAIN_LAYOUT)

@section('title', 'Ubah Komponen Layanan')

@section('content')
    @include('layanan-komponen._form', [
        'model' => $model,
        'referrer' => $referrer,
        'action' => route(LayananKomponenConstant::RouteUpdateProcess, ['id' => $model->id]),
    ])
@endsection

