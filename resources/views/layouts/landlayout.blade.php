<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Optik Gumelar</title>

    <!-- Tailwind CSS & Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body class="bg-slate-50 min-h-screen flex flex-col">

    <!-- NAVBAR -->
    <nav class="fixed top-0 w-full z-50 bg-white/95 backdrop-blur-md border-b border-slate-200/80">
        <div class="flex justify-between items-center px-6 lg:px-10 py-4">
        <div>
            <a href="/" class="text-2xl font-bold tracking-tight text-slate-900 flex items-center gap-2">
                <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-teal-700 text-white shadow-sm"><i class="bi bi-eyeglasses"></i></span>
                <span>Optik <span class="text-teal-700">Gumelar</span></span>
            </a>
        </div>

        <!-- Desktop Menu -->
        <div class="hidden md:flex space-x-7 items-center">
            <a href="/" class="text-slate-600 hover:text-teal-700 font-medium transition">Beranda</a>

            <!-- Dropdown: Produk -->
            <div class="relative">
    <button type="button" onclick="toggleProdukDropdown()" id="produk-toggle" class="text-slate-600 hover:text-slate-900 font-medium transition flex items-center gap-1">
        Produk
        <svg id="produk-chevron" class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </button>

    <div id="produk-dropdown" class="hidden absolute left-0 top-full mt-3 w-44 bg-white border border-slate-200 rounded-xl shadow-xl py-2 z-50">
        <a href="/produk/frame" class="block px-4 py-2 text-sm text-slate-600 hover:bg-teal-50 hover:text-teal-700 transition">Frame</a>
        <a href="/produk/lensa" class="block px-4 py-2 text-sm text-slate-600 hover:bg-teal-50 hover:text-teal-700 transition">Lensa</a>
        <a href="/produk/aksesoris" class="block px-4 py-2 text-sm text-slate-600 hover:bg-teal-50 hover:text-teal-700 transition">Aksesoris</a>
    </div>
</div>

            <a href="/tentang-kami" class="text-slate-600 hover:text-teal-700 font-medium transition">Tentang Kami</a>
            <a href="/kontak" class="text-slate-600 hover:text-teal-700 font-medium transition">Kontak</a>
            @auth
            <a href="/dashboard" class="text-slate-600 hover:text-teal-700 font-medium transition">Dashboard</a>
            @else
            <a href="/login" class="text-slate-600 hover:text-teal-700 font-medium transition">Login</a>
            @endauth
            <a href="/cabang" class="text-slate-600 hover:text-teal-700 font-medium transition">Cabang</a>
            <a href="{{ route('cart.index') }}" class="relative text-slate-600 hover:text-teal-700 font-medium transition" aria-label="Keranjang belanja">
                <i class="bi bi-bag text-lg"></i>
                <span id="cart-count" class="{{ session('cart') ? '' : 'hidden' }} absolute -right-3 -top-2 flex h-5 min-w-5 items-center justify-center rounded-full bg-[#f27d63] px-1 text-[10px] font-bold text-white">{{ collect(session('cart', []))->sum('quantity') }}</span>
            </a>
            
            <a href="https://wa.me/6281313293991" target="_blank" rel="noopener noreferrer" class="border border-teal-700 px-4 py-2 rounded-xl hover:bg-teal-800 hover:text-white transition flex gap-2 items-center bg-teal-700 text-white font-medium shadow-sm">
                <i class="bi bi-whatsapp"></i><span>Whatsapp</span>
            </a>
        </div>
        <button type="button" id="mobile-menu-toggle" class="md:hidden flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 text-slate-600" aria-label="Buka menu navigasi" aria-expanded="false">
            <i class="bi bi-list text-xl"></i>
        </button>
        </div>

        <div id="mobile-menu" class="hidden border-t border-slate-100 bg-white px-6 pb-5 pt-3 md:hidden">
            <div class="grid gap-1 text-sm font-semibold">
                <a href="/" class="rounded-lg px-3 py-2 text-slate-600 hover:bg-[#e3f3ef] hover:text-teal-700">Beranda</a>
                <a href="/produk/frame" class="rounded-lg px-3 py-2 text-slate-600 hover:bg-[#e3f3ef] hover:text-teal-700">Frame</a>
                <a href="/produk/lensa" class="rounded-lg px-3 py-2 text-slate-600 hover:bg-[#e3f3ef] hover:text-teal-700">Lensa</a>
                <a href="/produk/aksesoris" class="rounded-lg px-3 py-2 text-slate-600 hover:bg-[#e3f3ef] hover:text-teal-700">Aksesoris</a>
                <a href="/tentang-kami" class="rounded-lg px-3 py-2 text-slate-600 hover:bg-[#e3f3ef] hover:text-teal-700">Tentang Kami</a>
                <a href="/kontak" class="rounded-lg px-3 py-2 text-slate-600 hover:bg-[#e3f3ef] hover:text-teal-700">Kontak</a>
                @auth
                <a href="/dashboard" class="rounded-lg px-3 py-2 text-slate-600 hover:bg-[#e3f3ef] hover:text-teal-700">Dashboard</a>
                @else
                <a href="/login" class="rounded-lg px-3 py-2 text-slate-600 hover:bg-[#e3f3ef] hover:text-teal-700">Login</a>
                @endauth
                <a href="{{ route('cart.index') }}" class="mt-2 rounded-xl bg-teal-700 px-3 py-2 text-center text-white">Buka Keranjang</a>
            </div>
        </div>
    </nav>

    <!-- CONTENT SECTION -->
    <main class="grow pt-20">
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="bg-[#132f3d] text-slate-300 pt-16 pb-8 mt-auto">
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
                        @auth
                        <li><a href="/dashboard" class="hover:text-sky-400 transition">Dashboard</a></li>
                        @else
                        <li><a href="/login" class="hover:text-sky-400 transition">Login</a></li>
                        @endauth
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
    document.querySelectorAll('.ajax-cart-form').forEach(function (form) {
        form.addEventListener('submit', async function (event) {
            event.preventDefault();

            const button = form.querySelector('button[type="submit"]');
            button.disabled = true;

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: new FormData(form),
                });

                if (!response.ok) {
                    throw new Error('Keranjang gagal diperbarui.');
                }

                const result = await response.json();
                const count = document.getElementById('cart-count');
                count.textContent = result.cart_count;
                count.classList.remove('hidden');
                window.showCartMessage(result.message);
            } catch (error) {
                window.showCartMessage(error.message, true);
            } finally {
                button.disabled = false;
            }
        });
    });

    window.showCartMessage = function (message, isError = false) {
        let feedback = document.getElementById('cart-feedback');
        if (!feedback) {
            feedback = document.createElement('div');
            feedback.id = 'cart-feedback';
            feedback.className = 'fixed right-5 top-24 z-[60] rounded-xl px-4 py-3 text-sm font-semibold shadow-lg';
            document.body.appendChild(feedback);
        }
        feedback.textContent = message;
        feedback.classList.toggle('bg-rose-600', isError);
        feedback.classList.toggle('bg-teal-700', !isError);
        feedback.classList.add('text-white');
        clearTimeout(window.cartMessageTimer);
        window.cartMessageTimer = setTimeout(function () { feedback.remove(); }, 2500);
    };

    function toggleProdukDropdown() {
        document.getElementById('produk-dropdown').classList.toggle('hidden');
        document.getElementById('produk-chevron').classList.toggle('rotate-180');
    }

    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');
    if (mobileMenuToggle && mobileMenu) {
        mobileMenuToggle.addEventListener('click', function () {
            const isOpen = !mobileMenu.classList.contains('hidden');
            mobileMenu.classList.toggle('hidden', isOpen);
            mobileMenuToggle.setAttribute('aria-expanded', String(!isOpen));
            mobileMenuToggle.innerHTML = isOpen ? '<i class="bi bi-list text-xl"></i>' : '<i class="bi bi-x-lg text-lg"></i>';
        });
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