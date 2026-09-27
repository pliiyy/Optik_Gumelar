@extends('layouts.landlayout')

@section('content')
<div class="max-w-5xl mx-auto px-6 lg:px-8 py-12">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-slate-900">Keranjang Pesanan</h1>
            <p class="text-slate-500 mt-2">Periksa produk sebelum mengirim pesanan ke toko.</p>
        </div>
        <a href="{{ url('/produk/lensa') }}" class="text-sm text-sky-600 hover:text-sky-700">Lanjut belanja</a>
    </div>

    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    @if($errors->any())<div class="alert alert-danger">{{ $errors->first() }}</div>@endif

    @if(empty($cart))
        <div class="bg-white border border-slate-200 rounded-xl p-12 text-center text-slate-500">Keranjang masih kosong.</div>
    @else
        <div class="bg-white border border-slate-200 rounded-xl overflow-hidden">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light"><tr><th>Produk</th><th>Harga</th><th>Jumlah</th><th>Total</th><th></th></tr></thead>
                    <tbody>
                    @foreach($cart as $key => $item)
                        <tr>
                            <td><strong>{{ $item['name'] }}</strong><div class="small text-muted">{{ $item['product_type'] === 'lens' ? 'Lensa' : 'Frame' }}</div></td>
                            <td>Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                            <td><form method="POST" action="{{ route('cart.update', $key) }}" class="d-flex gap-2">@csrf @method('PATCH')<input type="number" name="quantity" min="1" max="{{ $item['stock'] }}" value="{{ $item['quantity'] }}" class="form-control form-control-sm" style="width: 90px"><button class="btn btn-sm btn-outline-primary">Ubah</button></form></td>
                            <td>Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</td>
                            <td><form method="POST" action="{{ route('cart.remove', $key) }}">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger">Hapus</button></form></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-top d-flex justify-content-between align-items-center gap-3 flex-wrap">
                <p class="mb-0 text-sm text-slate-500">Pesanan akan berstatus pending sampai dikonfirmasi di toko.</p>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#checkoutModal">Pesan Sekarang</button>
            </div>
        </div>

        <div class="modal fade" id="checkoutModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-primary text-white"><h5 class="modal-title">Detail Rencana Kedatangan</h5><button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button></div>
                    <form method="POST" action="{{ route('cart.checkout') }}">
                        @csrf
                        <div class="modal-body">
                            <p class="text-sm text-slate-600">Isi tanggal rencana datang ke toko untuk menyelesaikan pesanan.</p>
                            <label for="planned_visit_date" class="form-label">Tanggal rencana datang</label>
                            <input id="planned_visit_date" type="date" name="planned_visit_date" min="{{ now()->toDateString() }}" class="form-control" required>
                            <label for="checkout_notes" class="form-label mt-3">Keterangan</label>
                            <textarea id="checkout_notes" name="notes" class="form-control" rows="4" maxlength="500" placeholder="Keterangan tambahan (opsional)"></textarea>
                        </div>
                        <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-primary">Kirim Pesanan</button></div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
