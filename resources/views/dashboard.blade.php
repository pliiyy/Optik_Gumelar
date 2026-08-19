@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<!-- Welcome Banner -->
<div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-linear-to-r from-blue-600 to-indigo-600 p-4 rounded-2xl text-white shadow-sm">
    <div>
        <h1 class="text-2xl font-bold">Selamat Datang, Administrator! 👋</h1>
        <p class="text-blue-100 text-sm mt-1">Berikut adalah ringkasan data operasional Optik Gumelar hari ini.</p>
    </div>
    <div class="flex gap-3">
        <a href="/kategori_lensa" class="bg-white/10 hover:bg-white/20 text-white text-xs font-semibold px-4 py-2.5 rounded-xl transition backdrop-blur-sm border border-white/10 flex items-center gap-2">
            <i class="bi bi-plus-lg"></i> Tambah Kategori
        </a>
    </div>
</div>

<!-- Stat Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

    <!-- Card 1: Total User -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6 hover:shadow-md transition duration-200 relative overflow-hidden">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Total User</p>
                <h3 class="text-3xl font-extrabold text-slate-800 mt-2">120</h3>
            </div>
            <div class="bg-blue-50 text-blue-600 w-12 h-12 rounded-2xl flex items-center justify-center text-xl">
                <i class="bi bi-people-fill"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center gap-1 text-xs text-emerald-600 font-semibold">
            <i class="bi bi-arrow-up-right"></i> <span>12% dari bulan lalu</span>
        </div>
    </div>

    <!-- Card 2: Kategori Produk (Lensa & Frame) -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6 hover:shadow-md transition duration-200 relative overflow-hidden">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Total Produk</p>
                <h3 class="text-3xl font-extrabold text-slate-800 mt-2">55</h3>
            </div>
            <div class="bg-amber-50 text-amber-600 w-12 h-12 rounded-2xl flex items-center justify-center text-xl">
                <i class="bi bi-eyeglasses"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center gap-1 text-xs text-slate-400 font-medium">
            <span>Stok Lensa & Frame Tersedia</span>
        </div>
    </div>

    <!-- Card 3: Transaksi -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6 hover:shadow-md transition duration-200 relative overflow-hidden">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Transaksi</p>
                <h3 class="text-3xl font-extrabold text-slate-800 mt-2">350</h3>
            </div>
            <div class="bg-emerald-50 text-emerald-600 w-12 h-12 rounded-2xl flex items-center justify-center text-xl">
                <i class="bi bi-receipt"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center gap-1 text-xs text-emerald-600 font-semibold">
            <i class="bi bi-arrow-up-right"></i> <span>8% dari bulan lalu</span>
        </div>
    </div>

</div>

<!-- Quick Actions & Recent Info Section -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    
    <!-- Quick Actions Panel -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6 lg:col-span-1">
        <h3 class="font-bold text-slate-800 text-base mb-4 flex items-center gap-2">
            <i class="bi bi-lightning-charge text-amber-500"></i> Aksi Cepat
        </h3>
        <div class="space-y-3">
            <a href="/kategori_lensa" class="w-full flex items-center justify-between p-3 rounded-xl bg-slate-50 hover:bg-blue-50 text-slate-600 hover:text-blue-600 transition text-sm font-medium">
                <span class="flex items-center gap-3"><i class="bi bi-circle-square"></i> Kelola Kategori Lensa</span>
                <i class="bi bi-chevron-right text-xs"></i>
            </a>
            <a href="/kategori_frame" class="w-full flex items-center justify-between p-3 rounded-xl bg-slate-50 hover:bg-blue-50 text-slate-600 hover:text-blue-600 transition text-sm font-medium">
                <span class="flex items-center gap-3"><i class="bi bi-eyeglasses"></i> Kelola Kategori Frame</span>
                <i class="bi bi-chevron-right text-xs"></i>
            </a>
            <a href="/reports" class="w-full flex items-center justify-between p-3 rounded-xl bg-slate-50 hover:bg-blue-50 text-slate-600 hover:text-blue-600 transition text-sm font-medium">
                <span class="flex items-center gap-3"><i class="bi bi-file-earmark-bar-graph"></i> Lihat Laporan</span>
                <i class="bi bi-chevron-right text-xs"></i>
            </a>
        </div>
    </div>

    <!-- Placeholder Aktivitas / Tabel Singkat -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6 lg:col-span-2">
        <h3 class="font-bold text-slate-800 text-base mb-4 flex items-center gap-2">
            <i class="bi bi-clock-history text-blue-500"></i> Sistem Status
        </h3>
        <div class="p-4 rounded-xl bg-blue-50/50 border border-blue-100 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-3 h-3 bg-emerald-500 rounded-full animate-pulse"></div>
                <div>
                    <p class="text-sm font-semibold text-slate-700">Database & Server Terhubung</p>
                    <p class="text-xs text-slate-400">Semua modul berjalan dengan normal dan stabil.</p>
                </div>
            </div>
            <span class="text-xs bg-emerald-100 text-emerald-700 font-bold px-2.5 py-1 rounded-full">Online</span>
        </div>
    </div>

</div>

@endsection