<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Optik Gumelar</title>

    <!-- Tailwind CSS & Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 min-h-screen flex flex-col">

    <!-- NAVBAR -->
    <nav class="fixed top-0 w-full z-50 flex justify-between items-center px-6 py-4 bg-white/80 backdrop-blur-md border-b border-slate-200">
        <div>
            <a href="/" class="text-2xl font-bold tracking-tighter text-slate-900">
                Optik Gumelar
            </a>
        </div>

        <!-- Desktop Menu -->
        <div class="hidden md:flex space-x-8 items-center">
            <a href="/" class="text-slate-600 hover:text-slate-900 font-medium transition">Beranda</a>

            <!-- Dropdown: Produk -->
            <div class="relative">
    <button type="button" onclick="toggleProdukDropdown()" id="produk-toggle" class="text-slate-600 hover:text-slate-900 font-medium transition flex items-center gap-1">
        Produk
        <svg id="produk-chevron" class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </button>

    <div id="produk-dropdown" class="hidden absolute left-0 top-full mt-3 w-40 bg-white border border-slate-200 rounded-lg shadow-lg py-2 z-50">
        <a href="/produk/frame" class="block px-4 py-2 text-sm text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition">Frame</a>
        <a href="/produk/lensa" class="block px-4 py-2 text-sm text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition">Lensa</a>
    </div>
</div>
            </div>

            <a href="/tentang-kami" class="text-slate-600 hover:text-slate-900 font-medium transition">Tentang Kami</a>
            <a href="/kontak" class="text-slate-600 hover:text-slate-900 font-medium transition">Kontak</a>
            <a href="/login" class="text-slate-600 hover:text-slate-900 font-medium transition">Login</a>
            <a href="/cabang" class="text-slate-600 hover:text-slate-900 font-medium transition">Cabang</a>
            
            <a href="https://wa.me/6281313293991" target="_blank" rel="noopener noreferrer" class="border border-slate-200 px-4 py-2 rounded-lg hover:bg-green-500 hover:text-white transition flex gap-2 items-center bg-green-400 text-slate-900 font-medium">
                <span>Whatsapp</span>
            </a>
        </div>
    </nav>

    <!-- CONTENT SECTION -->
    <main class="flex-grow pt-20">
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="bg-slate-900 text-slate-300 pt-16 pb-8 mt-auto">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">
                <div class="space-y-6">
                    <h2 class="text-2xl font-bold text-white tracking-tighter">Optik Gumelar</h2>
                    <p class="text-sm leading-relaxed text-slate-400">
                        Menyediakan kacamata resep, lensa kontak, dan pemeriksaan mata berkualitas dengan pilihan frame stylish dan perawatan ahli.
                    </p>
                </div>
                <div>
                    <h3 class="text-white font-semibold mb-6">Navigasi</h3>
                    <ul class="space-y-4 text-sm">
                        <li><a href="/" class="hover:text-sky-400 transition">Beranda</a></li>
                        <li><a href="/tentang-kami" class="hover:text-sky-400 transition">Tentang Kami</a></li>
                        <li><a href="/kontak" class="hover:text-sky-400 transition">Kontak</a></li>
                        <li><a href="/login" class="hover:text-sky-400 transition">Login</a></li>
                        <li><a href="/cabang" class="hover:text-sky-400 transition">Cabang</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-white font-semibold mb-6">Layanan Kami</h3>
                    <ul class="space-y-4 text-sm text-slate-400">
                        <li>Pemeriksaan Mata</li>
                        <li>Kacamata Resep</li>
                        <li>Lensa Kontak</li>
                        <li>Servis dan Perawatan</li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-white font-semibold mb-6">Hubungi Kami</h3>
                    <ul class="space-y-4 text-sm text-slate-400">
                        <li>📍 Perum Griya Bandung Asri Barat (GBA Barat) Blok C3 No. 07, Bandung</li>
                        <li>📞 +62 813-1329-3991</li>
                        <li>✉️ info@optikgumelar.com</li>
                    </ul>
                </div>
            </div>
            <div class="pt-8 border-t border-slate-800 flex flex-col md:flex-row justify-between items-center gap-4 text-xs text-slate-500 uppercase tracking-widest">
                <p>© 2026 Optik Gumelar. All rights reserved.</p>
            </div>
        </div>
    </footer>
<script>
    function toggleProdukDropdown() {
        document.getElementById('produk-dropdown').classList.toggle('hidden');
        document.getElementById('produk-chevron').classList.toggle('rotate-180');
    }

    document.addEventListener('click', function (e) {
        const toggle = document.getElementById('produk-toggle');
        const dropdown = document.getElementById('produk-dropdown');
        if (toggle && dropdown && !toggle.contains(e.target) && !dropdown.contains(e.target)) {
            dropdown.classList.add('hidden');
            document.getElementById('produk-chevron').classList.remove('rotate-180');
        }
    });
</script>
</body>
</html>