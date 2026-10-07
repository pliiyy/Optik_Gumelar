@extends('layouts.app')

@section('title', 'Pengaturan Profil')

@section('content')
<div class="mx-auto max-w-3xl">
    <div class="mb-8">
        <p class="mb-2 text-sm font-bold uppercase tracking-[.18em] text-teal-700">Akun Anda</p>
        <h1 class="text-3xl font-bold text-slate-900">Pengaturan Profil</h1>
        <p class="mt-2 text-slate-500">Perbarui alamat dan nomor HP untuk keperluan pesanan dan faktur.</p>
    </div>

    @if(session('success'))
        <div class="mb-6 rounded-xl border border-teal-100 bg-teal-50 px-4 py-3 text-sm font-medium text-teal-800" role="status">
            <i class="bi bi-check-circle me-2" aria-hidden="true"></i>{{ session('success') }}
        </div>
    @endif

    <form action="{{ route('settings.profile.update') }}" method="POST" class="space-y-6 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm md:p-8">
        @csrf
        @method('PUT')

        <div>
            <label for="address" class="mb-2 block text-sm font-semibold text-slate-700">Alamat</label>
            <textarea id="address" name="address" rows="4" maxlength="500" autocomplete="street-address" class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:border-teal-500 focus:outline-none" placeholder="Masukkan alamat lengkap">{{ old('address', $user->address) }}</textarea>
            @error('address')
                <p class="mt-2 text-sm text-rose-700">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="phone" class="mb-2 block text-sm font-semibold text-slate-700">Nomor HP</label>
            <input id="phone" name="phone" type="tel" value="{{ old('phone', $user->phone) }}" maxlength="30" autocomplete="tel" inputmode="tel" class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:border-teal-500 focus:outline-none" placeholder="Contoh: 081234567890">
            @error('phone')
                <p class="mt-2 text-sm text-rose-700">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex flex-wrap justify-end gap-3 border-t border-slate-100 pt-5">
            <a href="{{ url('/dashboard') }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 px-5 py-3 text-sm font-semibold text-slate-600 hover:bg-slate-50">Kembali</a>
            <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-xl bg-teal-700 px-5 py-3 text-sm font-bold text-white hover:bg-teal-800">
                <i class="bi bi-check2-circle" aria-hidden="true"></i> Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
