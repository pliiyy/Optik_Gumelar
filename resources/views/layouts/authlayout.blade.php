<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Akun') | Optik Gumelar</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="auth-page">
    @include('components.floating-cart')

    <div class="auth-shell">
        <aside class="auth-brand-panel">
            <div class="auth-brand-content">
                <a href="/" class="auth-logo">
                    <img src="{{ asset('logo.png') }}" alt="Logo Optik Gumelar">
                </a>
                <p class="auth-eyebrow">OPTIK GUMELAR</p>
                <h1>Jernihkan pandangan, nyaman beraktivitas.</h1>
                <p class="auth-brand-description">Temukan pilihan kacamata dan lensa yang cocok untuk menemani setiap momen Anda.</p>
            </div>
            <span class="auth-brand-decoration auth-brand-decoration-one"></span>
            <span class="auth-brand-decoration auth-brand-decoration-two"></span>
        </aside>

        <main class="auth-main">
            <div class="auth-topline">
                <span>@yield('topline', 'Selamat datang di Optik Gumelar')</span>
                <a href="/">Kembali ke toko</a>
            </div>
            <section class="auth-card">
                @yield('content')
            </section>
            <p class="auth-copyright">&copy; {{ date('Y') }} Optik Gumelar</p>
        </main>
    </div>
</body>
</html>
