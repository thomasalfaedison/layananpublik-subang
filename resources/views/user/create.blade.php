@php
    use App\Constants\UserConstant;
    
    $breadcrumbs[] = ['label' => 'User', 'url' => route(UserConstant::RouteIndex,['id_role' => $model->id_role])];
    $breadcrumbs[] = 'Tambah User';
@endphp

@extends(LayoutConstant::MAIN_LAYOUT)

@section('title', 'Tambah User')
    
@section('content')
    @include('user._form', [
        'model' => $model,
        'listUserRole' => $listUserRole,
        'referrer' => $referrer,
        'action' => route(UserConstant::RouteCreateProcess,['id_role' => $model->id_role]),
    ])
@endsection