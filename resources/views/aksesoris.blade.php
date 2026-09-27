@extends('layouts.landlayout')

@section('content')
<div class="max-w-7xl mx-auto px-6 lg:px-8 py-12">

    <nav class="text-sm text-slate-500 mb-6">
        <a href="/" class="hover:text-slate-900 transition">Beranda</a>
        <span class="mx-2">/</span>
        <span class="text-slate-900 font-medium">Aksesoris</span>
    </nav>

    <div class="mb-10">
        <h1 class="text-3xl md:text-4xl font-bold text-slate-900 tracking-tight">Aksesoris Kacamata</h1>
        <p class="text-slate-500 mt-2 max-w-2xl">Lengkapi kebutuhan kacamata Anda dengan aksesoris praktis dan berkualitas.</p>
    </div>

    @php
        $aksesoris = [
            ['id' => 'hard-case-kacamata', 'nama' => 'Hard Case Kacamata', 'deskripsi' => 'Pelindung kokoh untuk menjaga frame tetap aman', 'harga' => 75000],
            ['id' => 'pouch-kacamata', 'nama' => 'Pouch Kacamata', 'deskripsi' => 'Pouch ringan untuk penyimpanan sehari-hari', 'harga' => 35000],
            ['id' => 'kain-lap-mikrofiber', 'nama' => 'Kain Lap Mikrofiber', 'deskripsi' => 'Membersihkan lensa tanpa meninggalkan goresan', 'harga' => 15000],
            ['id' => 'tali-kacamata', 'nama' => 'Tali Kacamata', 'deskripsi' => 'Tali nyaman agar kacamata tetap mudah dijangkau', 'harga' => 25000],
            ['id' => 'cairan-pembersih-lensa', 'nama' => 'Cairan Pembersih Lensa', 'deskripsi' => 'Membersihkan lensa dari debu dan minyak', 'harga' => 30000],
            ['id' => 'obeng-mini-kacamata', 'nama' => 'Obeng Mini Kacamata', 'deskripsi' => 'Peralatan praktis untuk mengencangkan sekrup frame', 'harga' => 20000],
        ];
    @endphp

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($aksesoris as $item)
        <div class="group bg-white border border-slate-200 rounded-xl overflow-hidden hover:shadow-lg transition">
            <div class="aspect-[4/3] bg-slate-100 flex items-center justify-center">
                <svg class="w-14 h-14 text-slate-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <rect x="4" y="6" width="16" height="12" rx="2" />
                    <path d="M8 10h8M8 14h5" />
                </svg>
            </div>
            <div class="p-5">
                <span class="text-xs font-medium text-sky-600 bg-sky-50 px-2 py-1 rounded-full">Aksesoris</span>
                <h3 class="font-semibold text-slate-900 mt-3">{{ $item['nama'] }}</h3>
                <p class="text-sm text-slate-500 mt-1">{{ $item['deskripsi'] }}</p>
                <div class="mt-4 flex flex-col gap-3">
                    <span class="font-bold text-slate-900">Rp {{ number_format($item['harga'], 0, ',', '.') }}</span>
                    <div class="grid grid-cols-2 gap-2">
                        <form action="{{ route('cart.add') }}" method="POST" class="ajax-cart-form">
                            @csrf
                            <input type="hidden" name="product_type" value="accessory">
                            <input type="hidden" name="product_key" value="{{ $item['id'] }}">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-lg border border-teal-700 px-3 py-2 text-xs font-bold text-teal-700 hover:bg-teal-50"><i class="bi bi-bag-plus"></i> Keranjang</button>
                        </form>
                        <form action="{{ route('cart.buyNow') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_type" value="accessory">
                            <input type="hidden" name="product_key" value="{{ $item['id'] }}">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-teal-700 px-3 py-2 text-xs font-bold text-white hover:bg-teal-800"><i class="bi bi-lightning-charge"></i> Beli Sekarang</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

</div>
@endsection