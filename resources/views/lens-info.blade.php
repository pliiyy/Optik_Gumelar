@extends('layouts.landlayout')

@section('content')
<div class="bg-slate-50 min-h-screen">
    <section class="bg-white border-b border-slate-200 py-16">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 text-center">
            <p class="text-sm font-semibold uppercase tracking-wider text-teal-700">Panduan Lensa</p>
            <h1 class="text-4xl font-bold text-slate-900 mt-3 mb-4">Kenali Pilihan Lensa Kacamata</h1>
            <p class="text-slate-500 max-w-2xl mx-auto">
                Setiap lensa memiliki fungsi yang berbeda. Kenali pilihan lensa berikut untuk menemukan yang sesuai dengan resep dan kebutuhan Anda.
            </p>
        </div>
    </section>

    <section class="py-16 max-w-7xl mx-auto px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach([
                ['name' => 'Single Vision Standard', 'category' => 'Lensa Resep', 'description' => 'Lensa berkekuatan satu fokus untuk membantu koreksi penglihatan pada satu jarak, sesuai resep kacamata Anda.'],
                ['name' => 'Anti Radiasi Blue Light', 'category' => 'Lensa Resep', 'description' => 'Lensa dengan lapisan untuk membantu mengurangi paparan sinar biru dari layar digital.'],
                ['name' => 'Photochromic (Transisi)', 'category' => 'Lensa Resep', 'description' => 'Lensa yang menjadi lebih gelap saat terkena sinar UV di luar ruangan dan kembali bening di dalam ruangan.'],
                ['name' => 'Progressive Multifocal', 'category' => 'Lensa Resep', 'description' => 'Lensa dengan transisi kekuatan untuk melihat jarak jauh, menengah, dan dekat tanpa garis pembatas yang terlihat.'],
                ['name' => 'Soft Contact Lens Bening', 'category' => 'Lensa Kontak', 'description' => 'Lensa kontak bening yang dikenakan langsung pada mata sebagai pilihan selain kacamata.'],
                ['name' => 'Contact Lens Silicone Hydrogel', 'category' => 'Lensa Kontak', 'description' => 'Lensa kontak berbahan silicone hydrogel yang dirancang untuk mendukung aliran oksigen ke mata.'],
                ['name' => 'Lapisan Anti Gores', 'category' => 'Lensa Tambahan', 'description' => 'Lapisan pelindung yang membantu mengurangi risiko goresan pada permukaan lensa saat digunakan dan dirawat dengan benar.'],
                ['name' => 'Lapisan Anti Air & Minyak', 'category' => 'Lensa Tambahan', 'description' => 'Lapisan yang membantu air dan minyak tidak mudah menempel sehingga lensa lebih mudah dibersihkan.'],
            ] as $lens)
                <article class="bg-white border border-slate-200 rounded-2xl p-6 hover:shadow-lg transition">
                    <span class="text-xs font-semibold text-teal-700 bg-teal-50 px-3 py-1 rounded-full">{{ $lens['category'] }}</span>
                    <h2 class="text-lg font-bold text-slate-900 mt-4">{{ $lens['name'] }}</h2>
                    <p class="text-sm leading-relaxed text-slate-600 mt-2">{{ $lens['description'] }}</p>
                </article>
            @endforeach
        </div>

        <div class="mt-10 text-center">
            <p class="text-sm text-slate-500 mb-4">Untuk menentukan pilihan yang tepat, konsultasikan kebutuhan dan resep Anda dengan optik.</p>
            <a href="/produk/lensa" class="inline-flex items-center gap-2 rounded-xl bg-teal-700 px-5 py-3 text-sm font-bold text-white hover:bg-teal-800 transition">
                Lihat Produk Lensa <i class="bi bi-arrow-right" aria-hidden="true"></i>
            </a>
        </div>
    </section>
</div>
@endsection
