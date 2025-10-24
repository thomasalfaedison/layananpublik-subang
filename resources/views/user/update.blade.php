@php
    use App\Constants\UserConstant;

    $breadcrumbs[] = ['label' => 'User', 'url' => route(UserConstant::RouteIndex,['id_role' => $model->id_role])];
    $breadcrumbs[] = 'Update User';
@endphp

@extends(LayoutConstant::MAIN_LAYOUT)

@section('title', 'Ubah User')
    
@section('content')
    @include('user._form', [
        'model' => $model,
        'referrer' => $referrer,
        'action' => route(UserConstant::RouteUpdateProcess,['id' => $model->id]),
    ])
@endsection