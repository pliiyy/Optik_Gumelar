@extends('layouts.landlayout')

@section('content')
<div class="pt-20">
    <!-- Hero Section Profile -->
    <section class="bg-slate-900 py-24 text-center text-white">
        <div class="container mx-auto px-6">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">
                Profil Optik Gumelar
            </h1>
            <p class="text-slate-400 max-w-2xl mx-auto">
                Mengenal lebih dekat Optik Gumelar sebagai penyedia layanan mata dan kacamata terpercaya Anda.
            </p>
        </div>
    </section>

    <!-- Sejarah & Tentang Kami -->
    <section class="py-24 container mx-auto px-6">
        <div class="flex flex-col md:flex-row items-center gap-16">
            <div class="md:w-1/2">
                <img
                    src="{{ asset('images/profile.png') }}"
                    alt="Optik Gumelar Store"
                    class="rounded-3xl shadow-2xl w-full object-cover"
                />
            </div>
            <div class="md:w-1/2">
                <h2 class="text-3xl font-bold text-slate-900 mb-6">
                    Menjaga Penglihatan Sejak Awal
                </h2>
                <p class="text-slate-600 mb-6 leading-relaxed">
                    Optik Gumelar hadir untuk memenuhi kebutuhan kacamata dan lensa dengan pemeriksaan mata profesional serta pilihan frame yang stylish.
                </p>
                <p class="text-slate-600 leading-relaxed">
                    Dari pemeriksaan rutin hingga kacamata resep, kami mendukung kualitas penglihatan Anda dengan layanan personal di setiap tahap.
                </p>
            </div>
        </div>
    </section>

    <!-- Visi & Misi -->
    <section class="py-24 bg-slate-50">
        <div class="container mx-auto px-6">
            <div class="grid md:grid-cols-2 gap-12">
                <!-- Visi -->
                <div class="bg-white p-10 rounded-3xl shadow-sm border border-slate-100">
                    <div class="w-12 h-12 bg-sky-100 text-sky-600 rounded-2xl flex items-center justify-center mb-6 font-bold text-xl">
                        👁️
                    </div>
                    <h3 class="text-2xl font-bold mb-4 text-slate-900">Visi Kami</h3>
                    <p class="text-slate-600 italic">
                        "Menjadi optik terpercaya yang membantu semua pelanggan mendapatkan penglihatan paling nyaman dan gaya kacamata terbaik."
                    </p>
                </div>

                <!-- Misi -->
                <div class="bg-white p-10 rounded-3xl shadow-sm border border-slate-100">
                    <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center mb-6 font-bold text-xl">
                        🎯
                    </div>
                    <h3 class="text-2xl font-bold mb-4 text-slate-900">Misi Kami</h3>
                    <ul class="space-y-3 text-slate-600">
                        <li class="flex gap-2">
                            <span>•</span> Menyediakan pemeriksaan mata lengkap dengan akurasi resep terbaik.
                        </li>
                        <li class="flex gap-2">
                            <span>•</span> Menawarkan kacamata dan lensa berkualitas untuk gaya dan kenyamanan penglihatan.
                        </li>
                        <li class="flex gap-2">
                            <span>•</span> Memberikan layanan purna jual termasuk perawatan lensa dan servis frame.
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Nilai Utama Kami (Core Values) -->
    <section class="py-24 bg-white">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-3xl font-bold text-slate-900 mb-12">
                Nilai-Nilai Utama Kami
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                <div class="p-8 group hover:bg-slate-900 transition-all duration-300 rounded-2xl border border-slate-100 hover:shadow-xl">
                    <div class="w-14 h-14 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:bg-indigo-500 group-hover:text-white transition-colors text-xl font-bold">
                        🛡️
                    </div>
                    <h4 class="text-xl font-bold mb-3 group-hover:text-white text-slate-900">
                        Kualitas Optik
                    </h4>
                    <p class="text-slate-600 group-hover:text-slate-300 text-sm">
                        Kami menjaga standar kualitas tinggi untuk kacamata, lensa, dan pemeriksaan mata.
                    </p>
                </div>

                <div class="p-8 group hover:bg-slate-900 transition-all duration-300 rounded-2xl border border-slate-100 hover:shadow-xl">
                    <div class="w-14 h-14 bg-orange-100 text-orange-600 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:bg-orange-500 group-hover:text-white transition-colors text-xl font-bold">
                        🤝
                    </div>
                    <h4 class="text-xl font-bold mb-3 group-hover:text-white text-slate-900">
                        Pelayanan Ramah
                    </h4>
                    <p class="text-slate-600 group-hover:text-slate-300 text-sm">
                        Layanan yang hangat dan personal untuk setiap pengunjung dan kebutuhan optik mereka.
                    </p>
                </div>

                <div class="p-8 group hover:bg-slate-900 transition-all duration-300 rounded-2xl border border-slate-100 hover:shadow-xl">
                    <div class="w-14 h-14 bg-rose-100 text-rose-600 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:bg-rose-500 group-hover:text-white transition-colors text-xl font-bold">
                        ⭐
                    </div>
                    <h4 class="text-xl font-bold mb-3 group-hover:text-white text-slate-900">
                        Kepuasan Pelanggan
                    </h4>
                    <p class="text-slate-600 group-hover:text-slate-300 text-sm">
                        Kepuasan pelanggan adalah ukuran utama kesuksesan Optik Gumelar.
                    </p>
                </div>

            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-12 container mx-auto px-6">
        <div class="bg-sky-600 rounded-3xl p-12 text-center text-white overflow-hidden relative">
            <div class="absolute top-0 left-0 w-64 h-64 bg-white/10 rounded-full -translate-x-1/2 -translate-y-1/2"></div>

            <h2 class="text-3xl md:text-4xl font-bold mb-6 relative z-10">
                Siap Melayani Kesehatan Mata Anda?
            </h2>
            <p class="text-sky-100 mb-10 max-w-xl mx-auto relative z-10">
                Hubungi kami sekarang untuk berkonsultasi mengenai resep kacamata atau layanan optik terbaik kami.
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