@extends('layouts.landlayout')

@section('content')
<div class="mx-auto max-w-6xl px-6 py-12 lg:px-8">
    <div class="mb-10">
        <p class="mb-2 text-sm font-bold uppercase tracking-[.18em] text-teal-700">Belanja Anda</p>
        <h1 class="text-3xl font-bold text-slate-900 md:text-4xl">Keranjang Belanja</h1>
        <p class="mt-2 text-slate-500">Periksa kembali pilihan produk Anda sebelum melanjutkan.</p>
    </div>

    @if(session('success'))
        <div class="mb-6 rounded-xl border border-teal-100 bg-teal-50 px-4 py-3 text-sm font-medium text-teal-800">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 rounded-xl border border-rose-100 bg-rose-50 px-4 py-3 text-sm font-medium text-rose-700">
            <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
        </div>
    @endif

    @if(count($cart) === 0)
        <div class="flex min-h-[360px] flex-col items-center justify-center rounded-3xl border border-dashed border-slate-300 bg-white px-6 text-center shadow-sm">
            <div class="mb-5 flex h-20 w-20 items-center justify-center rounded-full bg-[#dff4ef] text-4xl text-teal-700">
                <i class="bi bi-bag"></i>
            </div>
            <h2 class="text-2xl font-bold text-slate-900">Silahkan berbelanja untuk menambahkan produk anda</h2>
            <p class="mt-2 max-w-md text-slate-500">Keranjang Anda masih kosong. Temukan frame atau lensa yang paling sesuai untuk kebutuhan Anda.</p>
            <a href="{{ url('/produk/frame') }}" class="mt-7 inline-flex items-center gap-2 rounded-xl bg-teal-700 px-5 py-3 text-sm font-bold text-white shadow-sm hover:bg-teal-800">
                Lanjutkan Belanja <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    @else
        <div class="grid gap-8 lg:grid-cols-[1fr_350px]">
            <div class="space-y-4">
                @foreach($cart as $key => $item)
                    <div class="flex flex-col gap-5 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:flex-row sm:items-center sm:justify-between">
                        <div class="flex items-center gap-4">
                            <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-xl bg-[#dff4ef] text-2xl text-teal-700">
                                <i class="bi {{ $item['product_type'] === 'lens' ? 'bi-circle' : ($item['product_type'] === 'frame' ? 'bi-eyeglasses' : 'bi-box-seam') }}"></i>
                            </div>
                            <div>
                                <span class="text-xs font-bold uppercase tracking-wider text-teal-700">{{ $item['category'] ?: ucfirst($item['product_type']) }}</span>
                                <h2 class="mt-1 font-bold text-slate-900">{{ $item['name'] }}</h2>
                                <p class="mt-1 text-sm font-semibold text-slate-600">Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                                <a href="{{ config('products.inventory_spreadsheet_url') }}" target="_blank" rel="noopener noreferrer" class="mt-1 inline-flex items-center gap-1 text-xs font-semibold text-teal-700 hover:text-teal-900">
                                    <i class="bi bi-box-arrow-up-right" aria-hidden="true"></i> Lihat detail stok
                                </a>
                            </div>
                        </div>
                        <div class="flex items-center justify-between gap-5 sm:justify-end">
                            <form action="{{ route('cart.update', $key) }}" method="POST" class="flex items-center gap-2">
                                @csrf
                                @method('PATCH')
                                <label for="quantity-{{ $key }}" class="sr-only">Jumlah</label>
                                <input id="quantity-{{ $key }}" type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" max="99" class="w-20 rounded-lg border border-slate-200 px-3 py-2 text-center text-sm font-semibold focus:border-teal-500 focus:outline-none">
                                <button type="submit" class="rounded-lg border border-slate-200 px-3 py-2 text-sm font-semibold text-slate-600 hover:border-teal-600 hover:text-teal-700" aria-label="Perbarui jumlah"><i class="bi bi-arrow-repeat"></i></button>
                            </form>
                            <div class="text-right">
                                <p class="font-bold text-slate-900">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</p>
                                <form action="{{ route('cart.remove', $key) }}" method="POST" class="mt-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs font-semibold text-rose-500 hover:text-rose-700">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <aside class="h-fit rounded-2xl bg-[#17324d] p-6 text-white shadow-xl">
                <p class="text-sm font-semibold text-teal-100">Ringkasan Pesanan</p>
                <div class="mt-6 flex items-end justify-between border-b border-white/15 pb-5">
                    <span class="text-slate-300">Total</span>
                    <span class="text-2xl font-bold">Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
                <a href="{{ url('/produk/frame') }}" class="mt-6 flex items-center justify-center gap-2 rounded-xl bg-white px-4 py-3 text-sm font-bold text-[#17324d] hover:bg-teal-50">
                    Lanjutkan Belanja <i class="bi bi-arrow-right"></i>
                </a>
                @guest
                    <p class="mt-4 text-center text-xs leading-relaxed text-slate-300">Login diperlukan untuk melanjutkan proses pembelian.</p>
                    <a href="{{ route('login') }}" class="mt-3 block text-center text-sm font-bold text-teal-200 hover:text-white">Login untuk Membeli</a>
                @else
                    <a href="{{ route('checkout.index') }}" class="mt-3 block text-center text-sm font-bold text-teal-200 hover:text-white">Checkout Semua Produk</a>
                @endguest
            </aside>
        </div>
    @endif
</div>
@endsection
