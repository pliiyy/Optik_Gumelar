@extends('layouts.landlayout')

@section('content')

@php
        $branches = [
            [
                'name' => 'Optik Gumelar Ciburaleng',
                'phone' => '+62 822-1234-5678',
                'query' => 'Optik Gumelar Ciburaleng',
                'address' => 'Jalan Ciburaleng No. 12, Bandung',
                'coord' => '-6.9662878,107.8181306',
            ],
            [
                'name' => 'Optik Gumelar Cinunuk',
                'phone' => '+62 822-2345-6789',
                'query' => 'Optik Gumelar Cinunuk',
                'address' => 'Jalan Cinunuk No. 45, Bandung',
                'coord' => '-6.9394172,107.7386285',
            ],
            [
                'name' => 'Optik Gumelar Cibiru',
                'phone' => '+62 822-3456-7890',
                'query' => 'Optik Gumelar Cibiru',
                'address' => 'Jalan Raya Cibiru No. 88, Bandung',
                'coord' => '-6.9341978,107.7173447',
            ],
            [
                'name' => 'Optik Gumelar Cipacing',
                'phone' => '+62 822-4567-8901',
                'query' => 'Optik Gumelar Cipacing',
                'address' => 'Jalan Cipacing No. 33, Bandung',
                'coord' => '-6.9471867,107.7589176',
            ],
        ];
    @endphp
 
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
                            </div>
                        </div>
 
                        <div class="h-72 sm:h-80">
                            <iframe
                                title="{{ $branch['name'] }}"
                                src="https://maps.google.com/maps?q={{ $branch['coord'] }}&{{ urlencode($branch['query']) }}&z=15&output=embed"
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