@extends('layouts.landlayout')

@section('content')
<div class="mx-auto max-w-3xl px-6 py-12 lg:px-8">
    <div class="mb-8">
        <p class="mb-2 text-sm font-bold uppercase tracking-[.18em] text-teal-700">Beli Sekarang</p>
        <h1 class="text-3xl font-bold text-slate-900">Konfirmasi Pembelian</h1>
        <p class="mt-2 text-slate-500">Pastikan produk dan jumlahnya sudah sesuai sebelum pesanan dibuat.</p>
    </div>

    @if($errors->any())
        <div class="mb-6 rounded-xl border border-rose-100 bg-rose-50 px-4 py-3 text-sm text-rose-700">{{ $errors->first() }}</div>
    @endif

    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="border-b border-slate-100 pb-5">
            @foreach($items as $item)
                <div class="flex items-start justify-between gap-4 {{ !$loop->last ? 'mb-4' : '' }}">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-teal-700">{{ $item['category'] }}</p>
                        <h2 class="mt-2 text-lg font-bold text-slate-900">{{ $item['name'] }}</h2>
                        <p class="mt-1 text-sm text-slate-500">Jumlah: {{ $item['quantity'] }}</p>
                    </div>
                    <p class="text-right font-bold text-slate-900">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</p>
                </div>
            @endforeach
            <div class="mt-5 flex items-center justify-between border-t border-slate-100 pt-4">
                <span class="font-semibold text-slate-600">Total transaksi</span>
                <span class="text-xl font-bold text-slate-900">Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>
        </div>

        <form action="{{ route('checkout.confirm') }}" method="POST" class="mt-6">
            @csrf
            <label for="notes" class="block text-sm font-semibold text-slate-700">Catatan pesanan <span class="font-normal text-slate-400">(opsional)</span></label>
            <textarea id="notes" name="notes" rows="3" maxlength="500" class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:border-teal-500 focus:outline-none" placeholder="Tambahkan kebutuhan atau catatan khusus"></textarea>
            <label class="mt-5 flex items-start gap-3 text-sm text-slate-600">
                <input type="checkbox" name="terms" value="1" required class="mt-1 h-4 w-4 rounded border-slate-300 text-teal-700 focus:ring-teal-500">
                <span>Saya memastikan data pesanan benar dan bersedia datang ke toko untuk konfirmasi serta proses selanjutnya.</span>
            </label>
            <button type="submit" class="mt-6 inline-flex w-full items-center justify-center gap-2 rounded-xl bg-teal-700 px-5 py-3 text-sm font-bold text-white hover:bg-teal-800"><i class="bi bi-check2-circle"></i> Konfirmasi dan Buat Pesanan</button>
        </form>
    </div>
</div>
@endsection