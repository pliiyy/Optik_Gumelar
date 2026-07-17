@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="grid grid-cols-1 md:grid-cols-3 gap-5">

    <div class="bg-white rounded-lg shadow p-5">
        <h5 class="text-gray-500">Total User</h5>
        <h2 class="text-3xl font-bold">120</h2>
    </div>

    <div class="bg-white rounded-lg shadow p-5">
        <h5 class="text-gray-500">Produk</h5>
        <h2 class="text-3xl font-bold">55</h2>
    </div>

    <div class="bg-white rounded-lg shadow p-5">
        <h5 class="text-gray-500">Transaksi</h5>
        <h2 class="text-3xl font-bold">350</h2>
    </div>

</div>

<div class="mt-5">

    <button class="btn btn-success">
        Tambah Data
    </button>

    <button class="btn btn-primary">
        Simpan
    </button>

</div>

@endsection