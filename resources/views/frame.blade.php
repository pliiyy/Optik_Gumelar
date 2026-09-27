@extends('layouts.landlayout')

@section('content')
<div class="max-w-7xl mx-auto px-6 lg:px-8 py-12">
    <nav class="text-sm text-slate-500 mb-6"><a href="/" class="hover:text-slate-900">Beranda</a><span class="mx-2">/</span><span class="text-slate-900 font-medium">Frame</span></nav>
    <div class="mb-10 flex items-start justify-between gap-4"><div><h1 class="text-3xl md:text-4xl font-bold text-slate-900">Koleksi Frame Kacamata</h1><p class="text-slate-500 mt-2">Daftar frame yang tersedia di database Optik Gumelar.</p></div>@auth @if(Auth::user()->role === 'PELANGGAN')<a href="{{ route('cart.index') }}" class="btn btn-primary whitespace-nowrap"><i class="bi bi-cart3 me-1"></i> Keranjang</a>@endif @endauth</div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($frames as $frame)
            <div class="group bg-white border border-slate-200 rounded-xl overflow-hidden hover:shadow-lg transition">
                <div class="aspect-[4/3] bg-slate-100 flex items-center justify-center"><svg class="w-14 h-14 text-slate-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><circle cx="6" cy="15" r="3.5"/><circle cx="18" cy="15" r="3.5"/><path d="M9.5 15h5M2.5 15l1-6a2 2 0 011.9-1.5M21.5 15l-1-6a2 2 0 00-1.9-1.5"/></svg></div>
                <div class="p-5">
                    <span class="text-xs font-medium text-sky-600 bg-sky-50 px-2 py-1 rounded-full">{{ $frame->category }}</span>
                    <h2 class="font-semibold text-slate-900 mt-3">{{ $frame->name }}</h2>
                    <p class="text-sm text-slate-500 mt-1">{{ $frame->description ?: 'Frame berkualitas untuk gaya dan kenyamanan Anda.' }}</p>
                    <p class="text-xs text-slate-400 mt-2">Stok: {{ $frame->stock }}</p>
                    <div class="flex items-center justify-between gap-2 mt-4"><span class="font-bold text-slate-900">Rp {{ number_format($frame->price, 0, ',', '.') }}</span>
                        @auth
                            @if(Auth::user()->role === 'PELANGGAN' && $frame->stock > 0)<div class="flex gap-2"><form method="POST" action="{{ route('cart.add') }}">@csrf<input type="hidden" name="product_type" value="frame"><input type="hidden" name="product_id" value="{{ $frame->id }}"><input type="hidden" name="quantity" value="1"><button type="submit" class="text-sm font-medium text-white bg-slate-600 hover:bg-slate-700 px-3 py-1.5 rounded-lg">Keranjang</button></form><button type="button" data-bs-toggle="modal" data-bs-target="#orderFrame{{ $frame->id }}" class="text-sm font-medium text-white bg-sky-600 hover:bg-sky-700 px-3 py-1.5 rounded-lg">Pesan Langsung</button></div>@else<span class="text-xs text-slate-400">{{ $frame->stock > 0 ? 'Hubungi toko' : 'Stok habis' }}</span>@endif
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-medium text-white bg-sky-600 hover:bg-sky-700 px-3 py-1.5 rounded-lg">Login untuk pesan</a>
                        @endauth
                    </div>
                </div>
            </div>
        @empty
            <p class="col-span-full text-center text-slate-500 py-10">Belum ada data frame.</p>
        @endforelse
    </div>
</div>

@auth
@if(Auth::user()->role === 'PELANGGAN')
@foreach($frames as $frame)
@if($frame->stock > 0)
<div class="modal fade" id="orderFrame{{ $frame->id }}" tabindex="-1" aria-hidden="true"><div class="modal-dialog"><div class="modal-content border-0 shadow"><div class="modal-header bg-primary text-white"><h5 class="modal-title">Pesan {{ $frame->name }}</h5><button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button></div><form method="POST" action="{{ route('orders.store') }}">@csrf<input type="hidden" name="product_type" value="frame"><input type="hidden" name="product_id" value="{{ $frame->id }}"><div class="modal-body"><p class="text-sm text-slate-600">Pesanan berstatus pending sampai dikonfirmasi di toko.</p><label for="quantity-frame-{{ $frame->id }}" class="form-label">Jumlah</label><input id="quantity-frame-{{ $frame->id }}" type="number" name="quantity" min="1" max="{{ $frame->stock }}" value="1" class="form-control" required><label for="date-frame-{{ $frame->id }}" class="form-label mt-3">Tanggal rencana datang</label><input id="date-frame-{{ $frame->id }}" type="date" name="planned_visit_date" min="{{ now()->toDateString() }}" class="form-control" required><label for="notes-frame-{{ $frame->id }}" class="form-label mt-3">Keterangan</label><textarea id="notes-frame-{{ $frame->id }}" name="notes" class="form-control" rows="3" placeholder="Keterangan pesanan (opsional)"></textarea></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button><button type="submit" class="btn btn-primary">Kirim Pesanan</button></div></form></div></div></div>
@endif
@endforeach
@endif
@endauth
@endsection
