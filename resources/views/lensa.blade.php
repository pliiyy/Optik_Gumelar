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
            ['nama' => 'Single Vision Standard', 'kategori' => 'Lensa Resep', 'fitur' => 'Minus/Plus hingga -6.00 / +4.00', 'harga' => 'Rp 150.000'],
            ['nama' => 'Anti Radiasi Blue Light', 'kategori' => 'Lensa Resep', 'fitur' => 'Filter cahaya biru layar', 'harga' => 'Rp 275.000'],
            ['nama' => 'Photochromic (Transisi)', 'kategori' => 'Lensa Resep', 'fitur' => 'Berubah gelap otomatis di luar ruangan', 'harga' => 'Rp 550.000'],
            ['nama' => 'Progressive Multifocal', 'kategori' => 'Lensa Resep', 'fitur' => 'Jarak dekat & jauh dalam satu lensa', 'harga' => 'Rp 850.000'],
            ['nama' => 'Soft Contact Lens Bening', 'kategori' => 'Lensa Kontak', 'fitur' => 'Pemakaian harian, daya tahan 3 bulan', 'harga' => 'Rp 120.000'],
            ['nama' => 'Contact Lens Silicone Hydrogel', 'kategori' => 'Lensa Kontak', 'fitur' => 'Oksigen tinggi, nyaman seharian', 'harga' => 'Rp 210.000'],
            ['nama' => 'Lapisan Anti Gores', 'kategori' => 'Lensa Tambahan', 'fitur' => 'Coating tambahan untuk semua jenis lensa', 'harga' => 'Rp 50.000'],
            ['nama' => 'Lapisan Anti Air & Minyak', 'kategori' => 'Lensa Tambahan', 'fitur' => 'Mudah dibersihkan, tahan noda', 'harga' => 'Rp 75.000'],
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
                <div class="flex items-center justify-between mt-4">
                    <span class="font-bold text-slate-900">{{ $item['harga'] }}</span>
                    <a href="https://wa.me/6281313293991?text=Halo,%20saya%20ingin%20tanya%20tentang%20{{ urlencode($item['nama']) }}" target="_blank" class="text-sm font-medium text-white bg-green-400 hover:bg-green-500 px-3 py-1.5 rounded-lg transition">Tanya</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

</div>
@endsection