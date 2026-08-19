@extends('layouts.landlayout')

@section('content')
<div class="bg-slate-50 min-h-screen">
    
    <!-- 1. Carousel Section -->
    @include('components.home-carousel')

    <!-- 2. Stats Section (Angka Kepercayaan) -->
    <div class="container mx-auto px-6 -mt-12 relative z-20">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 bg-white p-8 rounded-2xl shadow-xl shadow-slate-200/50">
            <div class="text-center border-b md:border-b-0 md:border-r border-slate-100 pb-4 md:pb-0">
                <h3 class="text-3xl font-bold text-sky-600">10rb+</h3>
                <p class="text-slate-500 font-medium">Nasabah Aktif</p>
            </div>
            <div class="text-center border-b md:border-b-0 md:border-r border-slate-100 pb-4 md:pb-0">
                <h3 class="text-3xl font-bold text-sky-600">24 Jam</h3>
                <p class="text-slate-500 font-medium">Layanan Bantuan</p>
            </div>
            <div class="text-center">
                <h3 class="text-3xl font-bold text-sky-600">Mudah</h3>
                <p class="text-slate-500 font-medium">Proses Administrasi</p>
            </div>
        </div>
    </div>

    <!-- 3. Services Section (Layanan Utama) -->
    <section class="py-24 container mx-auto px-6">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-slate-900 mb-4">Layanan Unggulan Kami</h2>
            <div class="w-20 h-1 bg-sky-600 mx-auto"></div>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-2 gap-8">
            <div class="p-8 bg-white rounded-2xl border border-slate-100 hover:shadow-lg transition">
                <div class="w-12 h-12 bg-sky-100 text-sky-600 rounded-lg flex items-center justify-center mb-6 text-2xl font-bold">
                    👁️
                </div>
                <h3 class="text-xl font-bold mb-3">Pemeriksaan Mata</h3>
                <p class="text-slate-600 text-sm">
                    Pemeriksaan mata lengkap dengan optometris untuk resep dan deteksi awal masalah penglihatan.
                </p>
            </div>
            
            <div class="p-8 bg-white rounded-2xl border border-slate-100 hover:shadow-lg transition">
                <div class="w-12 h-12 bg-sky-100 text-sky-600 rounded-lg flex items-center justify-center mb-6 text-2xl font-bold">
                    👓
                </div>
                <h3 class="text-xl font-bold mb-3">Kacamata Resep</h3>
                <p class="text-slate-600 text-sm">
                    Frame stylish dan lensa berkualitas dengan pengukuran presisi untuk kebutuhan resep Anda.
                </p>
            </div>
        </div>
    </section>

    <!-- 4. Solusi Terpercaya -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <div class="flex flex-col md:flex-row items-center gap-12">
                <div class="md:w-1/2">
                    <h2 class="text-3xl font-bold text-slate-900 mb-6">Solusi Terpercaya untuk Kesehatan Mata Anda</h2>
                    <p class="text-slate-600 mb-8">
                        Kami menyediakan layanan optik lengkap dengan pemeriksaan mata, kacamata resep, dan perawatan lensa untuk kenyamanan visual Anda.
                    </p>

                    <div class="space-y-4">
                        @foreach([
                            ['title' => 'Proses Transparan', 'desc' => 'Setiap tahapan pengajuan dipantau secara terbuka.'],
                            ['title' => 'Keamanan Data', 'desc' => 'Data nasabah dilindungi dengan sistem enkripsi standar industri.'],
                            ['title' => 'Tim Ahli', 'desc' => 'Dukungan dari profesional berpengalaman di bidangnya.']
                        ] as $item)
                            <div class="flex gap-4">
                                <div class="shrink-0 w-6 h-6 rounded-full bg-sky-600 flex items-center justify-center text-white text-xs">✓</div>
                                <div>
                                    <h4 class="font-bold text-slate-800">{{ $item['title'] }}</h4>
                                    <p class="text-sm text-slate-500">{{ $item['desc'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="md:w-1/2 grid grid-cols-2 gap-4">
                    <div class="bg-slate-100 h-64 rounded-2xl overflow-hidden">
                        <img src="{{ asset('images/credit.png') }}" class="w-full h-full object-cover" alt="Credit">
                    </div>
                    <div class="bg-sky-600 h-64 rounded-2xl mt-8 overflow-hidden">
                        <img src="{{ asset('images/tech.png') }}" class="w-full h-full object-cover" alt="Tech">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 5. Cara Kerja Kami -->
    <section class="py-24 bg-slate-50">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-3xl font-bold mb-16">Cara Kerja Kami</h2>
            <div class="grid md:grid-cols-4 gap-8 relative">
                
                @foreach([
                    ['step' => '01', 'title' => 'Konsultasi', 'desc' => 'Hubungi tim kami untuk konsultasi awal.'],
                    ['step' => '02', 'title' => 'Analisis Resep', 'desc' => 'Optometris kami memastikan resep mata Anda akurat.'],
                    ['step' => '03', 'title' => 'Pilih Frame', 'desc' => 'Pilih frame yang nyaman dan sesuai gaya Anda.'],
                    ['step' => '04', 'title' => 'Pengerjaan', 'desc' => 'Kacamata diproduksi dan siap dipakai dalam beberapa hari.']
                ] as $item)
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-100">
                        <span class="text-4xl font-black text-slate-200 block mb-4">{{ $item['step'] }}</span>
                        <h4 class="font-bold text-slate-800 mb-2">{{ $item['title'] }}</h4>
                        <p class="text-sm text-slate-500">{{ $item['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- 6. Call to Action -->
    <section class="py-12 container mx-auto px-6">
        <div class="bg-sky-600 rounded-3xl p-12 text-center text-white overflow-hidden relative">
            <div class="absolute top-0 left-0 w-64 h-64 bg-white/10 rounded-full -translate-x-1/2 -translate-y-1/2"></div>

            <h2 class="text-3xl md:text-4xl font-bold mb-6 relative z-10">Siap Mengembangkan Bisnis Anda?</h2>
            <p class="text-sky-100 mb-10 max-w-xl mx-auto relative z-10">
                Hubungi kami sekarang untuk mendapatkan penawaran terbaik atau solusi teknologi yang tepat sasaran.
            </p>
            <div class="flex flex-wrap justify-center gap-4 relative z-10">
                <a class="bg-white text-sky-600 px-8 py-3 rounded-full font-bold hover:bg-slate-100 transition" href="https://wa.me/6281313293991" target="_blank" rel="noopener noreferrer">
                    Hubungi Kami
                </a>
                <a href="/portfolio" class="bg-transparent border border-white px-8 py-3 rounded-full font-bold hover:bg-white/10 transition">
                    Lihat Portfolio
                </a>
            </div>
        </div>
    </section>

</div>
@endsection