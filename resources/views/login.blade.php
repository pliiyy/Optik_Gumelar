@extends('layouts.landlayout')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-2xl shadow-xl border border-slate-100">
        <div class="text-center">
            <h2 class="text-3xl font-bold text-slate-900 tracking-tighter">Login</h2>
            <p class="mt-2 text-sm text-slate-600">Masuk ke akun Optik Gumelar Anda</p>
        </div>

        <form class="mt-8 space-y-6"  method="POST" action="/login">
            @csrf
            <div class="rounded-md shadow-sm space-y-4">
                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700">Email Address</label>
                    <input id="email" name="email" type="email" required 
                        class="appearance-none rounded-lg relative block w-full px-3 py-3 border border-slate-300 placeholder-slate-500 text-slate-900 focus:outline-none focus:ring-sky-500 focus:border-sky-500 focus:z-10 sm:text-sm mt-1"
                        placeholder="nama@email.com">
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700">Password</label>
                    <input id="password" name="password" type="password" required 
                        class="appearance-none rounded-lg relative block w-full px-3 py-3 border border-slate-300 placeholder-slate-500 text-slate-900 focus:outline-none focus:ring-sky-500 focus:border-sky-500 focus:z-10 sm:text-sm mt-1"
                        placeholder="••••••••">
                </div>
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember_me" name="remember" type="checkbox" 
                        class="h-4 w-4 text-sky-600 focus:ring-sky-500 border-slate-300 rounded">
                    <label for="remember_me" class="ml-2 block text-sm text-slate-900">Ingat saya</label>
                </div>
            </div>

            <div>
                <button type="submit" 
                    class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-bold rounded-lg text-white bg-sky-600 hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500 transition">
                    Masuk
                </button>
            </div>
        </form>

        @if ($errors->any())
            <div class="mt-4 p-4 bg-red-50 text-red-700 text-sm rounded-lg">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
</div>
@endsection