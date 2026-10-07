@extends('layouts.authlayout')

@section('title', 'Masuk')
@section('topline', 'Masuk ke akun Anda')
@section('content')
    <div class="auth-heading">
        <img class="auth-heading-logo" src="{{ asset('logo.png') }}" alt="Logo Optik Gumelar">
        <h2>Masuk</h2>
        <p>Masukkan detail akun Anda untuk melanjutkan.</p>
    </div>

    <form class="auth-form" method="POST" action="{{ route('login.post') }}">
        @csrf
        <div class="auth-field">
            <label for="email">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" required autofocus placeholder="nama@email.com">
        </div>

        <div class="auth-field">
            <label for="password">Password</label>
            <input id="password" name="password" type="password" autocomplete="current-password" required placeholder="Masukkan password">
        </div>

        <label class="auth-remember" for="remember_me">
            <input id="remember_me" name="remember" type="checkbox" value="1">
            <span>Ingat saya</span>
        </label>

        <button class="auth-submit" type="submit">Masuk</button>
    </form>

    @if ($errors->any())
        <div class="auth-alert auth-alert-error" role="alert">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    @if (session('success'))
        <div class="auth-alert auth-alert-success" role="status">{{ session('success') }}</div>
    @endif

    <p class="auth-switch">Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a></p>
@endsection