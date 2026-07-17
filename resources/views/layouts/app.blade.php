<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Laravel App')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">

    <!-- Navbar -->
    <nav class="bg-blue-600 text-white shadow">
        <div class="max-w-7xl mx-auto flex justify-between items-center px-6 py-4">
            <h1 class="text-xl font-bold">
                Laravel App
            </h1>

            <div class="space-x-4">
                <a href="/" class="hover:text-gray-200">Home</a>
                <a href="/kategori_lensa" class="hover:text-gray-200">kategori lensa</a>
                <a href="/contact" class="hover:text-gray-200">Contact</a>
            </div>
        </div>
    </nav>

    <div class="flex">

        <!-- Sidebar -->
        <aside class="w-64 min-h-screen bg-white shadow-md">
            <div class="p-5 border-b">
                <h2 class="font-bold text-lg">
                    Menu
                </h2>
            </div>

            <ul class="p-3 space-y-2">
                <li>
                    <a href="/" class="block p-2 rounded hover:bg-blue-100">
                        Dashboard
                    </a>
                </li>

                <li>
                    <a href="/kategori_lensa" class="block p-2 rounded hover:bg-blue-100">
                        Kategori Lensa
                    </a>
                </li>
                <li>
                    <a href="/kategori_frame" class="block p-2 rounded hover:bg-blue-100">
                        Kategori Frame
                    </a>
                </li>
                <li>
                    <a href="/users" class="block p-2 rounded hover:bg-blue-100">
                        User
                    </a>
                </li>

                <li>
                    <a href="/reports" class="block p-2 rounded hover:bg-blue-100">
                        Laporan
                    </a>
                </li>
                
            </ul>
        </aside>

        <!-- Content -->
        <main class="flex-1 p-6">

            <!-- Bootstrap Card -->
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    @yield('title')
                </div>

                <div class="card-body">

                    @yield('content')

                </div>
            </div>

        </main>

    </div>

</body>
</html>