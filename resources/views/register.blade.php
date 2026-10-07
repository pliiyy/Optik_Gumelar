@extends('layouts.authlayout')

@section('title', 'Daftar')
@section('topline', 'Buat akun pelanggan')
@section('content')
    <div class="auth-heading">
        <img class="auth-heading-logo" src="{{ asset('logo.png') }}" alt="Logo Optik Gumelar">
        <h2>Buat Akun</h2>
        <p>Daftar sebagai pelanggan Optik Gumelar.</p>
    </div>

    <form class="auth-form" method="POST" action="{{ route('register.store') }}">
        @csrf
        <div class="auth-field">
            <label for="name">Nama Lengkap</label>
            <input id="name" name="name" type="text" value="{{ old('name') }}" autocomplete="name" required autofocus placeholder="Nama lengkap">
            @error('name')
                <p class="auth-field-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="auth-field">
            <label for="email">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" required placeholder="nama@email.com">
            @error('email')
                <p class="auth-field-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="auth-field">
            <label for="password">Password</label>
            <input id="password" name="password" type="password" autocomplete="new-password" required placeholder="Minimal 8 karakter">
            @error('password')
                <p class="auth-field-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="auth-field">
            <label for="password_confirmation">Konfirmasi Password</label>
            <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required placeholder="Ulangi password">
        </div>

        <button class="auth-submit" type="submit">Daftar</button>
    </form>

    <p class="auth-switch">Sudah punya akun? <a href="{{ route('login') }}">Masuk sekarang</a></p>
@endsection
