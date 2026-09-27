@extends('layouts.landlayout')

@section('content')

@php($branches = config('branches'))
 
    <div class="pt-20 bg-slate-50 min-h-screen">
 
        {{-- Hero --}}
        <section class="bg-white border-b border-slate-200 py-20">
            <div class="container mx-auto px-6 text-center">
                <h1 class="text-4xl md:text-5xl font-bold text-slate-900 mb-4">
                    Cabang Optik Gumelar
                </h1>
                <p class="text-slate-500 max-w-2xl mx-auto text-lg">
                    Temukan cabang Optik Gumelar di Ciburaleng, Cinunuk, Cibiru, dan Cipacing
                    lengkap dengan nomor telepon dan peta lokasi.
                </p>
            </div>
        </section>
 
        {{-- Branch list --}}
        <section class="py-24 container mx-auto px-6">
            <div class="grid gap-8 lg:grid-cols-2">
                @foreach ($branches as $branch)
                    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                        <div class="p-8">
                            <h2 class="text-2xl font-bold text-slate-900 mb-3">
                                {{ $branch['name'] }}
                            </h2>
                            <p class="text-slate-500 mb-4">
                                {{ $branch['address'] }}
                            </p>
 
                            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:gap-6">
                                <div class="flex items-center gap-3 text-slate-700">
                                    {{-- Phone icon (Heroicons outline, inline SVG — no lucide-react dependency) --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-sky-600" fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M2.25 6.75c0 8.284 6.716 15 15 15h1.5a2.25 2.25 0 002.25-2.25v-1.372a1.5 1.5 0 00-1.06-1.435l-3.663-1.099a1.5 1.5 0 00-1.599.44l-.879.879a12.03 12.03 0 01-5.61-5.61l.879-.879a1.5 1.5 0 00.44-1.599L8.907 3.31A1.5 1.5 0 007.472 2.25H6.1A2.25 2.25 0 003.85 4.5v.75" />
                                    </svg>
                                    <span>{{ $branch['phone'] }}</span>
                                </div>

                                <a
                                    href="https://wa.me/{{ preg_replace('/\D+/', '', $branch['phone']) }}?text={{ urlencode('Halo, saya ingin bertanya tentang cabang ' . $branch['name'] . '.') }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="inline-flex items-center justify-center gap-2 rounded-lg bg-green-600 px-4 py-2 font-semibold text-white transition hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2"
                                >
                                    <i class="bi bi-whatsapp" aria-hidden="true"></i>
                                    <span>Chat WhatsApp</span>
                                </a>
 
                                <div class="flex items-center gap-3 text-slate-700">
                                    {{-- Map pin icon --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-sky-600" fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                    </svg>
                                    <span>Lokasi cabang di peta</span>
                                </div>

                                <a
                                    href="https://www.google.com/maps/search/?api=1&query={{ urlencode($branch['latitude'] . ',' . $branch['longitude']) }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="inline-flex items-center justify-center gap-2 rounded-lg border border-sky-600 px-4 py-2 font-semibold text-sky-700 transition hover:bg-sky-50 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2"
                                >
                                    <span>Buka di Google Maps</span>
                                </a>
                            </div>
                        </div>
 
                        <div class="h-72 sm:h-80">
                            <iframe
                                title="{{ $branch['name'] }}"
                                src="https://maps.google.com/maps?q={{ urlencode($branch['latitude'] . ',' . $branch['longitude'] . ' ' . $branch['query']) }}&z=15&output=embed"
                                class="w-full h-full border-0"
                                allowfullscreen
                                loading="lazy">
                            </iframe>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
 
    </div>
@endsection