<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') | Optik Gumelar</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body class="bg-slate-50 text-slate-800">

    <!-- Slim Navbar -->
    <nav class="bg-white border-b border-slate-200 fixed top-0 w-full z-50 h-14 flex items-center justify-between px-6 shadow-sm">
        <div class="flex items-center gap-4">
            <span class="font-bold text-blue-600 text-lg">Optik Gumelar</span>
            <span class="text-slate-300">|</span>
            <span class="text-xs text-slate-500 font-medium">ADMIN DASHBOARD</span>
        </div>
        
        <div class="flex items-center gap-4">
            <a href="{{ route('logout') }}" class="text-xs font-semibold text-slate-500 hover:text-blue-600 transition">
                <i class="bi bi-logout mr-1"></i> Logout
            </a>
            <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-xs">
                AD
            </div>
        </div>
    </nav>

    <!-- Main Wrapper -->
    <div class="flex pt-14 h-screen">

        <!-- Sidebar -->
        <aside class="w-56 bg-slate-900 text-slate-300 p-4 space-y-8">
            <div class="space-y-1">
                <p class="px-3 text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2">Menu</p>
                
                @php
                    $menu = [
                        ['url' => '/dashboard', 'icon' => 'bi-speedometer2', 'label' => 'Dashboard'],
                        ['url' => '/kategori_lensa', 'icon' => 'bi-circle-square', 'label' => 'Kategori Lensa'],
                        ['url' => '/kategori_frame', 'icon' => 'bi-eyeglasses', 'label' => 'Kategori Frame'],
                        ['url' => '/users', 'icon' => 'bi-people', 'label' => 'Users'],
                        ['url' => '/reports', 'icon' => 'bi-graph-up', 'label' => 'Laporan'],
                    ];
                @endphp

                @foreach($menu as $item)
                    <a href="{{ $item['url'] }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition hover:bg-blue-600 hover:text-white {{ request()->is(ltrim($item['url'], '/')) ? 'bg-blue-600 text-white' : '' }}">
                        <i class="bi {{ $item['icon'] }}"></i> {{ $item['label'] }}
                    </a>
                @endforeach
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto p-4">
            <div class=" mx-auto">

                <!-- Main Card -->
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4">
                    @yield('content')
                </div>

            </div>
        </main>
    </div>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</body>
</html>