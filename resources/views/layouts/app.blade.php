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
    <nav class="bg-white/95 backdrop-blur-md border-b border-slate-200/80 fixed top-0 w-full z-50 h-16 flex items-center justify-between px-5 md:px-8 shadow-sm">
        <div class="flex items-center gap-4">
            <a href="/" class="no-underline flex items-center gap-2"><span class="flex h-9 w-9 items-center justify-center rounded-xl bg-teal-700 text-white"><i class="bi bi-eyeglasses"></i></span><span class="font-bold text-slate-900 text-lg">Optik <span class="text-teal-700">Gumelar</span></span></a>
            <span class="hidden sm:inline text-slate-300">/</span>
            <span class="hidden sm:inline rounded-full bg-[#e3f3ef] px-3 py-1 text-[10px] text-teal-700 font-bold tracking-widest">RUANG KERJA</span>
        </div>
        
        <div class="flex items-center gap-4">
            <a href="{{ route('logout') }}" class="rounded-lg px-3 py-2 text-xs font-semibold text-slate-500 hover:bg-[#e3f3ef] hover:text-teal-700 transition">
                <i class="bi bi-logout mr-1"></i> Logout
            </a>
            <div class="w-9 h-9 rounded-xl bg-[#dff4ef] flex items-center justify-center text-teal-800 font-bold text-xs">
                {{ strtoupper(substr(Auth::user()->name ?? 'AD', 0, 2)) }}
            </div>
        </div>
    </nav>

    <!-- Main Wrapper -->
    <div class="flex pt-16 min-h-screen">

        <!-- Sidebar -->
        <aside class="w-60 shrink-0 bg-[#132f3d] text-slate-300 p-4 space-y-8">
            <div class="space-y-1">
                <p class="px-3 text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2">Menu</p>
                
                @php
                    $role = Auth::user()->role ?? 'PELANGGAN';
                    $menu = [
                        ['url' => '/dashboard', 'icon' => 'bi-speedometer2', 'label' => 'Dashboard'],
                    ];

                    if (in_array($role, ['ADMIN', 'KARYAWAN'])) {
                        $menu[] = ['url' => '/lenses', 'icon' => 'bi-circle-square', 'label' => 'Manajemen Lensa'];
                        $menu[] = ['url' => '/frames', 'icon' => 'bi-eyeglasses', 'label' => 'Manajemen Frame'];
                    }

                    if ($role === 'ADMIN') {
                        $menu[] = ['url' => '/users', 'icon' => 'bi-people', 'label' => 'Users'];
                    }

                    $menu[] = ['url' => '/orders', 'icon' => 'bi-receipt', 'label' => 'Transaksi'];
                @endphp

                @foreach($menu as $item)
                    <a href="{{ $item['url'] }}" class="flex items-center gap-3 px-3 py-3 rounded-xl text-sm transition hover:bg-teal-700 hover:text-white {{ request()->is(ltrim($item['url'], '/')) ? 'bg-teal-700 text-white shadow-lg shadow-teal-950/20' : '' }}">
                        <i class="bi {{ $item['icon'] }}"></i> {{ $item['label'] }}
                    </a>
                @endforeach
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto p-4 md:p-8">
            <div class="max-w-7xl mx-auto">

                <!-- Main Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-5 md:p-8">
                    @yield('content')
                </div>

            </div>
        </main>
    </div>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')

</body>
</html>