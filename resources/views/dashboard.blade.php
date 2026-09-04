@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
@php
    $role = $role ?? (Auth::user()->role ?? 'PELANGGAN');
    $nama = Auth::user()->name ?? 'Pengguna';
@endphp

<div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-linear-to-r from-blue-600 to-indigo-600 p-4 rounded-2xl text-white shadow-sm">
    <div>
        <h1 class="text-2xl font-bold">
            @if($role === 'ADMIN')
                Selamat Datang, Administrator! 👋
            @elseif($role === 'KARYAWAN')
                Selamat Datang, Karyawan! 👋
            @else
                Selamat Datang, {{ $nama }}! 👋
            @endif
        </h1>
        <p class="text-blue-100 text-sm mt-1">
            @if($role === 'ADMIN')
                Ringkasan operasional Optik Gumelar secara lengkap.
            @elseif($role === 'KARYAWAN')
                Pantau data produk dan status pesanan hari ini.
            @else
                Lihat produk dan status pesanan Anda.
            @endif
        </p>
    </div>
</div>

@if($role === 'ADMIN')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Total User</p>
                    <h3 class="text-3xl font-extrabold text-slate-800 mt-2">{{ $totalUsers }}</h3>
                </div>
                <div class="bg-blue-50 text-blue-600 w-12 h-12 rounded-2xl flex items-center justify-center text-xl"><i class="bi bi-people-fill"></i></div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Total Lensa</p>
                    <h3 class="text-3xl font-extrabold text-slate-800 mt-2">{{ $totalLenses }}</h3>
                </div>
                <div class="bg-amber-50 text-amber-600 w-12 h-12 rounded-2xl flex items-center justify-center text-xl"><i class="bi bi-circle-square"></i></div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Total Frame</p>
                    <h3 class="text-3xl font-extrabold text-slate-800 mt-2">{{ $totalFrames }}</h3>
                </div>
                <div class="bg-emerald-50 text-emerald-600 w-12 h-12 rounded-2xl flex items-center justify-center text-xl"><i class="bi bi-eyeglasses"></i></div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6 lg:col-span-1">
            <h3 class="font-bold text-slate-800 text-base mb-4 flex items-center gap-2"><i class="bi bi-lightning-charge text-amber-500"></i> Aksi Cepat</h3>
            <div class="space-y-3">
                <a href="/lenses" class="w-full flex items-center justify-between p-3 rounded-xl bg-slate-50 hover:bg-blue-50 text-slate-600 hover:text-blue-600 transition text-sm font-medium"><span class="flex items-center gap-3"><i class="bi bi-circle-square"></i> Kelola Lensa</span><i class="bi bi-chevron-right text-xs"></i></a>
                <a href="/frames" class="w-full flex items-center justify-between p-3 rounded-xl bg-slate-50 hover:bg-blue-50 text-slate-600 hover:text-blue-600 transition text-sm font-medium"><span class="flex items-center gap-3"><i class="bi bi-eyeglasses"></i> Kelola Frame</span><i class="bi bi-chevron-right text-xs"></i></a>
                <a href="/users" class="w-full flex items-center justify-between p-3 rounded-xl bg-slate-50 hover:bg-blue-50 text-slate-600 hover:text-blue-600 transition text-sm font-medium"><span class="flex items-center gap-3"><i class="bi bi-people"></i> Kelola User</span><i class="bi bi-chevron-right text-xs"></i></a>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6 lg:col-span-2">
            <h3 class="font-bold text-slate-800 text-base mb-4 flex items-center gap-2"><i class="bi bi-clock-history text-blue-500"></i> Sistem Status</h3>
            <div class="p-4 rounded-xl bg-blue-50/50 border border-blue-100 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-3 h-3 bg-emerald-500 rounded-full animate-pulse"></div>
                    <div>
                        <p class="text-sm font-semibold text-slate-700">Database & Server Terhubung</p>
                        <p class="text-xs text-slate-400">Total produk saat ini: {{ $totalProducts }} item aktif.</p>
                    </div>
                </div>
                <span class="text-xs bg-emerald-100 text-emerald-700 font-bold px-2.5 py-1 rounded-full">Online</span>
            </div>
        </div>
    </div>
@elseif($role === 'KARYAWAN')
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Total Lensa</p>
                    <h3 class="text-3xl font-extrabold text-slate-800 mt-2">{{ $totalLenses }}</h3>
                </div>
                <div class="bg-amber-50 text-amber-600 w-12 h-12 rounded-2xl flex items-center justify-center text-xl"><i class="bi bi-circle-square"></i></div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Total Frame</p>
                    <h3 class="text-3xl font-extrabold text-slate-800 mt-2">{{ $totalFrames }}</h3>
                </div>
                <div class="bg-emerald-50 text-emerald-600 w-12 h-12 rounded-2xl flex items-center justify-center text-xl"><i class="bi bi-eyeglasses"></i></div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6">
            <h3 class="font-bold text-slate-800 text-base mb-4 flex items-center gap-2"><i class="bi bi-lightning-charge text-amber-500"></i> Aksi Cepat</h3>
            <div class="space-y-3">
                <a href="/lenses" class="w-full flex items-center justify-between p-3 rounded-xl bg-slate-50 hover:bg-blue-50 text-slate-600 hover:text-blue-600 transition text-sm font-medium"><span class="flex items-center gap-3"><i class="bi bi-circle-square"></i> Kelola Lensa</span><i class="bi bi-chevron-right text-xs"></i></a>
                <a href="/frames" class="w-full flex items-center justify-between p-3 rounded-xl bg-slate-50 hover:bg-blue-50 text-slate-600 hover:text-blue-600 transition text-sm font-medium"><span class="flex items-center gap-3"><i class="bi bi-eyeglasses"></i> Kelola Frame</span><i class="bi bi-chevron-right text-xs"></i></a>
                <a href="/orders" class="w-full flex items-center justify-between p-3 rounded-xl bg-slate-50 hover:bg-blue-50 text-slate-600 hover:text-blue-600 transition text-sm font-medium"><span class="flex items-center gap-3"><i class="bi bi-receipt"></i> Kelola Pesanan</span><i class="bi bi-chevron-right text-xs"></i></a>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6">
            <h3 class="font-bold text-slate-800 text-base mb-4 flex items-center gap-2"><i class="bi bi-clock-history text-blue-500"></i> Status Hari Ini</h3>
            <div class="p-4 rounded-xl bg-blue-50/50 border border-blue-100">
                <p class="text-sm font-semibold text-slate-700">Produk siap dipantau dan pesanan dapat dikonfirmasi.</p>
                <p class="text-xs text-slate-400 mt-2">Total item aktif: {{ $totalProducts }}</p>
            </div>
        </div>
    </div>
@else
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Pesanan Pending</p>
                    <h3 class="text-3xl font-extrabold text-slate-800 mt-2">{{ $pendingOrders ?? 0 }}</h3>
                </div>
                <div class="bg-warning-subtle text-warning w-12 h-12 rounded-2xl flex items-center justify-center text-xl"><i class="bi bi-hourglass-split"></i></div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Pesanan Selesai</p>
                    <h3 class="text-3xl font-extrabold text-slate-800 mt-2">{{ $completedOrders ?? 0 }}</h3>
                </div>
                <div class="bg-success-subtle text-success w-12 h-12 rounded-2xl flex items-center justify-center text-xl"><i class="bi bi-check-circle-fill"></i></div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Pesanan Batal</p>
                    <h3 class="text-3xl font-extrabold text-slate-800 mt-2">{{ $canceledOrders ?? 0 }}</h3>
                </div>
                <div class="bg-danger-subtle text-danger w-12 h-12 rounded-2xl flex items-center justify-center text-xl"><i class="bi bi-x-circle-fill"></i></div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="font-bold text-slate-800 text-base mb-0 flex items-center gap-2"><i class="bi bi-receipt text-blue-500"></i> Data Pesanan Saya</h3>
                <a href="/orders" class="btn btn-sm btn-primary">Lihat Semua Pesanan</a>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Produk</th>
                            <th>Jumlah</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($customerOrders ?? [] as $order)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @if($order->product_type === 'lens')
                                        {{ $order->lens?->name ?? 'Lensa' }}
                                    @else
                                        {{ $order->frame?->name ?? 'Frame' }}
                                    @endif
                                </td>
                                <td>{{ $order->quantity }}</td>
                                <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                <td>
                                    <span class="badge bg-{{ $order->status === 'selesai' ? 'success' : ($order->status === 'batal' ? 'danger' : 'warning') }} text-white">
                                        {{ strtoupper($order->status) }}
                                    </span>
                                </td>
                                <td>
                                    @if($order->status === 'pending')
                                        Harus datang ke toko untuk proses selanjutnya.
                                    @elseif($order->status === 'selesai')
                                        Pesanan telah selesai.
                                    @else
                                        Pesanan dibatalkan.
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">Belum ada data pesanan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif

@endsection