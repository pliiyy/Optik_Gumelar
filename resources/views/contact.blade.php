@extends('layouts.landlayout')

@section('content')
<div class="pt-20 bg-slate-50 min-h-screen">
    <!-- 1. Header Section -->
    <section class="bg-white border-b border-slate-200 py-16">
        <div class="container mx-auto px-6 text-center">
            <h1 class="text-4xl font-bold text-slate-900 mb-4">
                Hubungi Kami
            </h1>
            <p class="text-slate-500 max-w-xl mx-auto">
                Butuh bantuan dengan resep kacamata, lensa kontak, atau pemeriksaan mata? Tim kami siap membantu Anda kapan saja.
            </p>
        </div>
    </section>

    <section class="py-20 container mx-auto px-6">
        <div class="grid lg:grid-cols-3 gap-12">
            <!-- 2. Informasi Kontak (Kiri) -->
            <div class="lg:col-span-1 space-y-8">
                <div>
                    <h3 class="text-xl font-bold text-slate-900 mb-6">
                        Informasi Kontak
                    </h3>
                    <div class="space-y-6">
                        
                        <div class="flex gap-4">
                            <div class="w-12 h-12 bg-sky-100 text-sky-600 rounded-2xl flex items-center justify-center shrink-0 font-bold text-lg">
                                📞
                            </div>
                            <div>
                                <p class="text-xs text-slate-400 uppercase font-bold tracking-wider">
                                    Telepon / WA
                                </p>
                                <p class="text-slate-700 font-medium">
                                    +62 813-1384-2963
                                </p>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <div class="w-12 h-12 bg-sky-100 text-sky-600 rounded-2xl flex items-center justify-center shrink-0 font-bold text-lg">
                                ✉️
                            </div>
                            <div>
                                <p class="text-xs text-slate-400 uppercase font-bold tracking-wider">
                                    Email Resmi
                                </p>
                                <p class="text-slate-700 font-medium">
                                    info@optikgumelar.com
                                </p>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <div class="w-12 h-12 bg-sky-100 text-sky-600 rounded-2xl flex items-center justify-center shrink-0 font-bold text-lg">
                                📍
                            </div>
                            <div>
                                <p class="text-xs text-slate-400 uppercase font-bold tracking-wider">
                                    Kantor Pusat
                                </p>
                                <p class="text-slate-700 font-medium text-sm leading-relaxed">
                                    Perum Griya Bandung Asri Barat (GBA Barat) Blok C3 No. 07, Kabupaten Bandung Jawa Barat
                                </p>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <div class="w-12 h-12 bg-sky-100 text-sky-600 rounded-2xl flex items-center justify-center shrink-0 font-bold text-lg">
                                🕒
                            </div>
                            <div>
                                <p class="text-xs text-slate-400 uppercase font-bold tracking-wider">
                                    Jam Operasional
                                </p>
                                <p class="text-slate-700 font-medium text-sm">
                                    Senin - Jumat: 08:00 - 17:00
                                </p>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Social Media Mini -->
                <div class="p-6 bg-sky-600 rounded-3xl text-white">
                    <h4 class="font-bold mb-2">Respon Cepat?</h4>
                    <p class="text-sky-100 text-sm mb-4">
                        Chat langsung dengan admin kami via WhatsApp untuk konsultasi instan.
                    </p>
                    <a
                        href="https://wa.me/6281313293991"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="block text-center w-full bg-white text-sky-600 p-3 rounded-xl font-bold text-sm hover:bg-sky-50 transition"
                    >
                        WhatsApp Sekarang
                    </a>
                </div>
            </div>

            <!-- 3. Formulir Pesan (Kanan) -->
            <div class="lg:col-span-2">
                <div class="bg-white p-8 md:p-12 rounded-3xl shadow-sm border border-slate-200">
                    <h3 class="text-2xl font-bold text-slate-900 mb-8">
                        Kirim Pesan
                    </h3>

                    <!-- Contoh penanganan alert sukses jika data terkirim -->
                    @if(session('success'))
                        <div class="mb-6 p-4 bg-emerald-50 text-emerald-700 text-sm rounded-xl border border-emerald-200">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="#" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @csrf

                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-slate-700">
                                Nama Lengkap
                            </label>
                            <input
                                type="text"
                                name="name"
                                placeholder="Masukkan nama Anda"
                                required
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-sky-500 focus:ring-2 focus:ring-sky-200 outline-none transition"
                            />
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-slate-700">
                                Alamat Email
                            </label>
                            <input
                                type="email"
                                name="email"
                                placeholder="email@contoh.com"
                                required
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-sky-500 focus:ring-2 focus:ring-sky-200 outline-none transition"
                            />
                        </div>

                        <div class="md:col-span-2 space-y-2">
                            <label class="text-sm font-semibold text-slate-700">
                                Subjek
                            </label>
                            <select name="subject" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-sky-500 outline-none transition bg-white">
                                <option>Pemeriksaan Mata</option>
                                <option>Konsultasi Kacamata</option>
                                <option>Lensa Kontak</option>
                                <option>Kerja Sama Bisnis</option>
                                <option>Lainnya</option>
                            </select>
                        </div>

                        <div class="md:col-span-2 space-y-2">
                            <label class="text-sm font-semibold text-slate-700">
                                Pesan Anda
                            </label>
                            <textarea
                                name="message"
                                rows="5"
                                placeholder="Tuliskan pesan atau pertanyaan Anda..."
                                required
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-sky-500 focus:ring-2 focus:ring-sky-200 outline-none transition resize-none"
                            ></textarea>
                        </div>

                        <div class="md:col-span-2">
                            <button
                                type="submit"
                                class="w-full md:w-fit bg-sky-600 text-white px-10 py-4 rounded-xl font-bold flex items-center justify-center gap-2 hover:bg-sky-700 transition shadow-lg shadow-sky-200"
                            >
                                Kirim Pesan 🚀
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. Google Maps Embed -->
    <section class="h-96 w-full bg-slate-200 overflow-hidden rounded-xl shadow-inner mt-12">
        <iframe
            title="Lokasi Kantor Optik Gumelar"
            src="https://maps.google.com/maps?q=-6.9762084,107.6482254&z=17&output=embed"
            class="w-full h-full border-0 transition-all duration-700"
            allowfullscreen
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"
        ></iframe>
    </section>
</div>
@endsection