@extends('layouts.app')

@section('title', 'Transaksi')

@section('content')
<div class="container-fluid px-4">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-receipt me-2"></i>Data Pesanan</h5>
                    @if(Auth::user()->role === 'PELANGGAN')
                        <button class="btn btn-light btn-sm text-primary fw-semibold px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#createOrderModal">
                            <i class="bi bi-plus-lg me-1"></i> Buat Pesanan
                        </button>
                    @endif
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Pelanggan</th>
                                    <th>Produk</th>
                                    <th>Qty</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    @if(Auth::user()->role !== 'PELANGGAN')
                                        <th class="text-center">Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($orders as $order)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $order->user->name ?? 'Unknown' }}</td>
                                        <td>
                                            @if($order->product_type === 'lens')
                                                {{ $order->lens?->name ?? 'Lensa' }}
                                            @else
                                                {{ $order->frame?->name ?? 'Frame' }}
                                            @endif
                                        </td>
                                        <td>{{ $order->quantity }}</td>
                                        <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                        <td>
                                            <span class="badge bg-{{ $order->status === 'selesai' ? 'success' : ($order->status === 'batal' ? 'danger' : 'warning') }} text-white">
                                                {{ strtoupper($order->status) }}
                                            </span>
                                        </td>
                                        @if(Auth::user()->role !== 'PELANGGAN')
                                            <td class="text-center">
                                                <form action="{{ route('orders.updateStatus', $order) }}" method="POST" class="d-inline-block">
                                                    @csrf
                                                    @method('PATCH')
                                                    <select name="status" class="form-select form-select-sm d-inline-block w-auto me-2" onchange="this.form.submit()">
                                                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                                        <option value="selesai" {{ $order->status === 'selesai' ? 'selected' : '' }}>Selesai</option>
                                                        <option value="batal" {{ $order->status === 'batal' ? 'selected' : '' }}>Batal</option>
                                                    </select>
                                                </form>
                                            </td>
                                        @endif
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4 text-muted">Belum ada data pesanan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if(Auth::user()->role === 'PELANGGAN')
<div class="modal fade" id="createOrderModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i>Buat Pesanan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('orders.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Jenis Produk</label>
                        <select name="product_type" id="product_type" class="form-select" required>
                            <option value="">Pilih produk</option>
                            <option value="lens">Lensa</option>
                            <option value="frame">Frame</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Produk</label>
                        <select name="product_id" id="product_id" class="form-select" required>
                            <option value="">Pilih produk...</option>
                            @foreach(App\Models\Lens::all() as $lens)
                                <option value="{{ $lens->id }}" data-type="lens">{{ $lens->name }} (Lensa)</option>
                            @endforeach
                            @foreach(App\Models\Frame::all() as $frame)
                                <option value="{{ $frame->id }}" data-type="frame">{{ $frame->name }} (Frame)</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Jumlah</label>
                        <input type="number" name="quantity" class="form-control" min="1" value="1" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Catatan</label>
                        <textarea name="notes" class="form-control" rows="3" placeholder="Tambahkan catatan atau kebutuhan khusus"></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success">Pesan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@push('scripts')
<script>
    $(document).ready(function () {
        $('#product_type').on('change', function () {
            const type = $(this).val();
            $('#product_id option').each(function () {
                const optionType = $(this).data('type');
                if (!type || optionType === type) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });
    });
</script>
@endpush
@endsection
