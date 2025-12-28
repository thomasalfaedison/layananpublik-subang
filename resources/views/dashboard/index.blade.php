<?php

use App\Components\Session;

/* @see \App\Http\Controllers\DashboardController::index() */

?>

@extends(LayoutConstant::MAIN_LAYOUT)

@section('title', 'Dashboard')

@section('content')
    
@include('dashboard._card-rekap-data')

@include('dashboard._card-layanan-produk')

@include('dashboard._card-layanan-penerima-manfaat')

@if (Session::isAdmin())
    @include('dashboard._card-instansi')
@endif

@endsection
