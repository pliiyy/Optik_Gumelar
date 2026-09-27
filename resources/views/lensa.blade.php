@extends('layouts.landlayout')

@section('content')
<div class="max-w-7xl mx-auto px-6 lg:px-8 py-12">

    <nav class="text-sm text-slate-500 mb-6">
        <a href="/" class="hover:text-slate-900 transition">Beranda</a>
        <span class="mx-2">/</span>
        <span class="text-slate-900 font-medium">Lensa</span>
    </nav>

    <div class="mb-10">
        <h1 class="text-3xl md:text-4xl font-bold text-slate-900 tracking-tight">Pilihan Lensa</h1>
        <p class="text-slate-500 mt-2 max-w-2xl">Lensa resep, lensa kontak, dan lensa tambahan dengan berbagai fitur perlindungan sesuai kebutuhan mata Anda.</p>
    </div>

    <div class="flex flex-wrap gap-3 mb-10">
        <button class="px-4 py-2 rounded-full bg-slate-900 text-white text-sm font-medium">Semua</button>
        <button class="px-4 py-2 rounded-full bg-white border border-slate-200 text-slate-600 text-sm font-medium hover:border-slate-400 transition">Lensa Resep</button>
        <button class="px-4 py-2 rounded-full bg-white border border-slate-200 text-slate-600 text-sm font-medium hover:border-slate-400 transition">Lensa Kontak</button>
        <button class="px-4 py-2 rounded-full bg-white border border-slate-200 text-slate-600 text-sm font-medium hover:border-slate-400 transition">Lensa Tambahan</button>
    </div>

    @php
        $lensa = [
            ['id' => 'single-vision-standard', 'nama' => 'Single Vision Standard', 'kategori' => 'Lensa Resep', 'fitur' => 'Minus/Plus hingga -6.00 / +4.00', 'harga' => 150000],
            ['id' => 'anti-radiasi-blue-light', 'nama' => 'Anti Radiasi Blue Light', 'kategori' => 'Lensa Resep', 'fitur' => 'Filter cahaya biru layar', 'harga' => 275000],
            ['id' => 'photochromic-transisi', 'nama' => 'Photochromic (Transisi)', 'kategori' => 'Lensa Resep', 'fitur' => 'Berubah gelap otomatis di luar ruangan', 'harga' => 550000],
            ['id' => 'progressive-multifocal', 'nama' => 'Progressive Multifocal', 'kategori' => 'Lensa Resep', 'fitur' => 'Jarak dekat & jauh dalam satu lensa', 'harga' => 850000],
            ['id' => 'soft-contact-lens-bening', 'nama' => 'Soft Contact Lens Bening', 'kategori' => 'Lensa Kontak', 'fitur' => 'Pemakaian harian, daya tahan 3 bulan', 'harga' => 120000],
            ['id' => 'contact-lens-silicone-hydrogel', 'nama' => 'Contact Lens Silicone Hydrogel', 'kategori' => 'Lensa Kontak', 'fitur' => 'Oksigen tinggi, nyaman seharian', 'harga' => 210000],
            ['id' => 'lapisan-anti-gores', 'nama' => 'Lapisan Anti Gores', 'kategori' => 'Lensa Tambahan', 'fitur' => 'Coating tambahan untuk semua jenis lensa', 'harga' => 50000],
            ['id' => 'lapisan-anti-air-minyak', 'nama' => 'Lapisan Anti Air & Minyak', 'kategori' => 'Lensa Tambahan', 'fitur' => 'Mudah dibersihkan, tahan noda', 'harga' => 75000],
        ];
    @endphp

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($lensa as $item)
        <div class="group bg-white border border-slate-200 rounded-xl overflow-hidden hover:shadow-lg transition">
            <div class="aspect-[4/3] bg-slate-100 flex items-center justify-center">
                <svg class="w-14 h-14 text-slate-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <circle cx="12" cy="12" r="9"/>
                    <circle cx="12" cy="12" r="4"/>
                </svg>
            </div>
            <div class="p-5">
                <span class="text-xs font-medium text-sky-600 bg-sky-50 px-2 py-1 rounded-full">{{ $item['kategori'] }}</span>
                <h3 class="font-semibold text-slate-900 mt-3">{{ $item['nama'] }}</h3>
                <p class="text-sm text-slate-500 mt-1">{{ $item['fitur'] }}</p>
                <div class="mt-4 flex flex-col gap-3">
                    <span class="font-bold text-slate-900">Rp {{ number_format($item['harga'], 0, ',', '.') }}</span>
                    <div class="grid grid-cols-2 gap-2">
                        <form action="{{ route('cart.add') }}" method="POST" class="ajax-cart-form">
                            @csrf
                            <input type="hidden" name="product_type" value="lens">
                            <input type="hidden" name="product_key" value="{{ $item['id'] }}">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-lg border border-teal-700 px-3 py-2 text-xs font-bold text-teal-700 hover:bg-teal-50"><i class="bi bi-bag-plus"></i> Keranjang</button>
                        </form>
                        <form action="{{ route('cart.buyNow') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_type" value="lens">
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