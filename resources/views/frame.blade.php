@extends('layouts.landlayout')

@section('content')
<div class="max-w-7xl mx-auto px-6 lg:px-8 py-12">

    <nav class="text-sm text-slate-500 mb-6">
        <a href="/" class="hover:text-slate-900 transition">Beranda</a>
        <span class="mx-2">/</span>
        <span class="text-slate-900 font-medium">Frame</span>
    </nav>

    <div class="mb-10">
        <h1 class="text-3xl md:text-4xl font-bold text-slate-900 tracking-tight">Koleksi Frame Kacamata</h1>
        <p class="text-slate-500 mt-2 max-w-2xl">Pilihan frame berkualitas dari berbagai model dan bahan, cocok untuk segala gaya dan kebutuhan sehari-hari.</p>
    </div>

    <div class="flex flex-wrap gap-3 mb-10">
        <button class="px-4 py-2 rounded-full bg-slate-900 text-white text-sm font-medium">Semua</button>
        <button class="px-4 py-2 rounded-full bg-white border border-slate-200 text-slate-600 text-sm font-medium hover:border-slate-400 transition">Pria</button>
        <button class="px-4 py-2 rounded-full bg-white border border-slate-200 text-slate-600 text-sm font-medium hover:border-slate-400 transition">Wanita</button>
        <button class="px-4 py-2 rounded-full bg-white border border-slate-200 text-slate-600 text-sm font-medium hover:border-slate-400 transition">Anak</button>
        <button class="px-4 py-2 rounded-full bg-white border border-slate-200 text-slate-600 text-sm font-medium hover:border-slate-400 transition">Kacamata Baca</button>
    </div>

    @php
        $frames = [
            ['nama' => 'Classic Round TR90', 'kategori' => 'Pria', 'bahan' => 'TR90 Ringan', 'harga' => 'Rp 350.000'],
            ['nama' => 'Cat Eye Acetate', 'kategori' => 'Wanita', 'bahan' => 'Acetate Premium', 'harga' => 'Rp 420.000'],
            ['nama' => 'Kids Flexible Frame', 'kategori' => 'Anak', 'bahan' => 'Silicone Fleksibel', 'harga' => 'Rp 275.000'],
            ['nama' => 'Titanium Rimless', 'kategori' => 'Pria', 'bahan' => 'Titanium', 'harga' => 'Rp 650.000'],
            ['nama' => 'Vintage Square Metal', 'kategori' => 'Wanita', 'bahan' => 'Stainless Metal', 'harga' => 'Rp 390.000'],
            ['nama' => 'Reading Glasses Basic', 'kategori' => 'Kacamata Baca', 'bahan' => 'Plastik Ringan', 'harga' => 'Rp 180.000'],
        ];
    @endphp

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($frames as $frame)
        <div class="group bg-white border border-slate-200 rounded-xl overflow-hidden hover:shadow-lg transition">
            <div class="aspect-[4/3] bg-slate-100 flex items-center justify-center">
                <svg class="w-14 h-14 text-slate-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <circle cx="6" cy="15" r="3.5"/>
                    <circle cx="18" cy="15" r="3.5"/>
                    <path d="M9.5 15h5M2.5 15l1-6a2 2 0 011.9-1.5M21.5 15l-1-6a2 2 0 00-1.9-1.5"/>
                </svg>
            </div>
            <div class="p-5">
                <span class="text-xs font-medium text-sky-600 bg-sky-50 px-2 py-1 rounded-full">{{ $frame['kategori'] }}</span>
                <h3 class="font-semibold text-slate-900 mt-3">{{ $frame['nama'] }}</h3>
                <p class="text-sm text-slate-500 mt-1">{{ $frame['bahan'] }}</p>
                <div class="flex items-center justify-between mt-4">
                    <span class="font-bold text-slate-900">{{ $frame['harga'] }}</span>
                    <a href="https://wa.me/6281313293991?text=Halo,%20saya%20ingin%20tanya%20tentang%20frame%20{{ urlencode($frame['nama']) }}" target="_blank" class="text-sm font-medium text-white bg-green-400 hover:bg-green-500 px-3 py-1.5 rounded-lg transition">Tanya</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

</div>
@endsection