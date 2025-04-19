@extends('layouts.app')

@section('title', 'Akses Tidak Diizinkan') <!-- Title halaman -->

@section('content')
<div class="container text-center mt-5">
    <h1 class="display-3">403</h1>
    <h2>Akses Tidak Diizinkan</h2>
    <p class="mt-3">Anda tidak memiliki izin untuk mengakses halaman ini.</p>
    <a href="{{ route('dashboard') }}" class="btn btn-primary">Kembali ke Dashboard</a>
</div>
@endsection
