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

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($frames as $frame)
        <div class="group bg-white border border-slate-200 rounded-xl overflow-hidden hover:shadow-lg transition flex flex-col justify-between">
            <div>
                <div class="aspect-4/3 bg-slate-100 flex items-center justify-center">
                    <svg class="w-14 h-14 text-slate-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <circle cx="6" cy="15" r="3.5"/>
                        <circle cx="18" cy="15" r="3.5"/>
                        <path d="M9.5 15h5M2.5 15l1-6a2 2 0 011.9-1.5M21.5 15l-1-6a2 2 0 00-1.9-1.5"/>
                    </svg>
                </div>
                <div class="p-5 pb-0">
                    <span class="text-xs font-medium text-sky-600 bg-sky-50 px-2 py-1 rounded-full">{{ $frame->category }}</span>
                    <h3 class="font-semibold text-slate-900 mt-3">{{ $frame->name }}</h3>
                    <p class="text-sm text-slate-500 mt-1">{{ $frame->description ?: 'Frame kacamata pilihan untuk kebutuhan sehari-hari.' }}</p>
                    <p class="mt-2 text-xs text-slate-500">Stok: {{ $frame->stock }}</p>
                    <a href="{{ config('products.inventory_spreadsheet_url') }}" target="_blank" rel="noopener noreferrer" class="mt-3 inline-flex items-center gap-1 text-xs font-semibold text-teal-700 hover:text-teal-900">
                        <i class="bi bi-box-arrow-up-right" aria-hidden="true"></i> Lihat detail stok
                    </a>
                </div>
            </div>

            <!-- Bagian Bawah: Harga & Tombol Berjejer Horizontal -->
            <div class="p-5 pt-4 mt-auto border-t border-slate-100 flex items-center justify-between gap-3">
                <span class="font-bold text-slate-900 text-base whitespace-nowrap">
                    Rp {{ number_format($frame->price, 0, ',', '.') }}
                </span>

                @if($frame->stock > 0)
                <div class="flex items-center gap-2">
                    <form action="{{ route('cart.add') }}" method="POST" class="ajax-cart-form">
                        @csrf
                        <input type="hidden" name="product_type" value="frame">
                        <input type="hidden" name="product_key" value="{{ $frame->catalog_key ?: 'db-' . $frame->id }}">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="inline-flex items-center justify-center gap-1 rounded-lg border border-teal-700 px-3 py-2 text-xs font-bold text-teal-700 hover:bg-teal-50 transition" title="Tambah ke Keranjang">
                            <i class="bi bi-bag-plus"></i> <span class="hidden sm:inline">Keranjang</span>
                        </button>
                    </form>

                    <form action="{{ route('cart.buyNow') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_type" value="frame">
                        <input type="hidden" name="product_key" value="{{ $frame->catalog_key ?: 'db-' . $frame->id }}">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="inline-flex items-center justify-center gap-1 rounded-lg bg-teal-700 px-3 py-2 text-xs font-bold text-white hover:bg-teal-800 transition whitespace-nowrap">
                            <i class="bi bi-lightning-charge"></i> Beli
                        </button>
                    </form>
                </div>
                @else
                    <span class="text-sm font-semibold text-slate-400">Stok habis</span>
                @endif
            </div>
        </div>
        @empty
            <p class="col-span-full text-center text-slate-500 py-10">Belum ada data frame.</p>
        @endforelse
    </div>
</div>
@endsection