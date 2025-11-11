@php
    use App\Components\Session;
@endphp

@extends(LayoutConstant::MAIN_LAYOUT)

@section('title', 'Dashboard')

@section('content')
    
@include('dashboard._card-rekap-data')

@if (Session::isAdmin())
    @include('dashboard._card-instansi')
@endif

@endsection