<?php

use App\Components\Session;

/* @see \App\Http\Controllers\DashboardController::index() */

?>

@extends(LayoutConstant::MAIN_LAYOUT)

@section('title', 'Dashboard')

@section('content')

@include('dashboard._card-rekap-data')

@include('dashboard._card-pivot-penerima-produk')

@include('dashboard._card-layanan-produk')

@include('dashboard._card-layanan-penerima-manfaat')

@include('dashboard._card-produk-per-penerima')

@include('dashboard._card-penerima-per-produk')

@if (Session::isAdmin())
    @include('dashboard._card-instansi')
@endif

@endsection
