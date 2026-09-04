@extends('layouts.landlayout')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-2xl shadow-xl border border-slate-100">
        <div class="text-center">
            <h2 class="text-3xl font-bold text-slate-900 tracking-tighter">Buat Akun</h2>
            <p class="mt-2 text-sm text-slate-600">Daftar sebagai pelanggan Optik Gumelar</p>
        </div>

        <form class="mt-8 space-y-5" method="POST" action="{{ route('register.store') }}">
            @csrf

            <div>
                <label for="name" class="block text-sm font-medium text-slate-700">Nama Lengkap</label>
                <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus
                    class="appearance-none rounded-lg relative block w-full px-3 py-3 border border-slate-300 placeholder-slate-500 text-slate-900 focus:outline-none focus:ring-sky-500 focus:border-sky-500 sm:text-sm mt-1"
                    placeholder="Nama lengkap">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-slate-700">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required
                    class="appearance-none rounded-lg relative block w-full px-3 py-3 border border-slate-300 placeholder-slate-500 text-slate-900 focus:outline-none focus:ring-sky-500 focus:border-sky-500 sm:text-sm mt-1"
                    placeholder="nama@email.com">
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-slate-700">Password</label>
                <input id="password" name="password" type="password" required
                    class="appearance-none rounded-lg relative block w-full px-3 py-3 border border-slate-300 placeholder-slate-500 text-slate-900 focus:outline-none focus:ring-sky-500 focus:border-sky-500 sm:text-sm mt-1"
                    placeholder="Minimal 8 karakter">
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-slate-700">Konfirmasi Password</label>
                <input id="password_confirmation" name="password_confirmation" type="password" required
                    class="appearance-none rounded-lg relative block w-full px-3 py-3 border border-slate-300 placeholder-slate-500 text-slate-900 focus:outline-none focus:ring-sky-500 focus:border-sky-500 sm:text-sm mt-1"
                    placeholder="Ulangi password">
            </div>

            <button type="submit"
                class="w-full flex justify-center py-3 px-4 border border-transparent text-sm font-bold rounded-lg text-white bg-sky-600 hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500 transition">
                Daftar
            </button>
        </form>

        <p class="text-center text-sm text-slate-600">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="font-semibold text-sky-600 hover:text-sky-700">Kembali ke login</a>
        </p>
    </div>
</div>
@endsection
