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
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">{{ session('success') }}</div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger" role="alert">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Transaksi</th>
                                    <th>Pelanggan</th>
                                    <th>Produk</th>
                                    <th>Qty</th>
                                    <th>Total</th>
                                    <th>Rencana Datang</th>
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
                                        <td>
                                            <span class="font-monospace small">{{ $order->transaction_code ?? 'Manual' }}</span>
                                            <a href="{{ route('orders.invoice', $order) }}" target="_blank" rel="noopener noreferrer" class="mt-2 inline-flex items-center gap-1 rounded-lg border border-teal-700 px-2.5 py-1.5 text-xs font-semibold text-teal-700 hover:bg-teal-50">
                                                <i class="bi bi-printer" aria-hidden="true"></i> Cetak Faktur
                                            </a>
                                        </td>
                                        <td>{{ $order->user->name ?? 'Unknown' }}</td>
                                        <td>
                                            @if($order->product_name)
                                                {{ $order->product_name }}
                                            @elseif($order->product_type === 'lens')
                                                {{ $order->lens?->name ?? 'Lensa' }}
                                            @elseif($order->product_type === 'accessory')
                                                {{ $order->accessory?->name ?? 'Aksesoris' }}
                                            @else
                                                {{ $order->frame?->name ?? 'Frame' }}
                                            @endif
                                            @if($order->branch_name)
                                                <span class="mt-1 block text-xs text-slate-500">{{ $order->branch_name }} · {{ number_format($order->branch_distance_km, 2, ',', '.') }} km</span>
                                            @endif
                                        </td>
                                        <td>{{ $order->quantity }}</td>
                                        <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                        <td>{{ $order->planned_visit_date ? \Illuminate\Support\Carbon::parse($order->planned_visit_date)->format('d-m-Y') : '-' }}</td>
                                        <td>
                                            <span class="badge bg-{{ $order->status === 'selesai' ? 'success' : ($order->status === 'batal' ? 'danger' : 'warning') }} text-white">
                                                {{ strtoupper($order->status) }}
                                            </span>
                                        </td>
                                        @if(Auth::user()->role !== 'PELANGGAN')
                                            <td class="text-center">
                                                <button type="button" class="btn btn-outline-primary btn-sm mb-1"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editOrderModal"
                                                    data-order-id="{{ $order->id }}"
                                                    data-planned-visit-date="{{ $order->planned_visit_date ? \Illuminate\Support\Carbon::parse($order->planned_visit_date)->format('Y-m-d') : '' }}"
                                                    data-customer-address="{{ $order->customer_address ?? $order->user?->address }}"
                                                    data-customer-phone="{{ $order->customer_phone ?? $order->user?->phone }}"
                                                    data-od-sph="{{ data_get($order->prescription, 'od.sph') }}"
                                                    data-od-cyl="{{ data_get($order->prescription, 'od.cyl') }}"
                                                    data-od-ax="{{ data_get($order->prescription, 'od.ax') }}"
                                                    data-od-pd="{{ data_get($order->prescription, 'od.pd') }}"
                                                    data-os-sph="{{ data_get($order->prescription, 'os.sph') }}"
                                                    data-os-cyl="{{ data_get($order->prescription, 'os.cyl') }}"
                                                    data-os-ax="{{ data_get($order->prescription, 'os.ax') }}"
                                                    data-os-pd="{{ data_get($order->prescription, 'os.pd') }}"
                                                    data-prescription-add="{{ data_get($order->prescription, 'add') }}">
                                                    <i class="bi bi-pencil-square me-1"></i>Edit Data
                                                </button>
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
                                        <td colspan="8" class="text-center py-4 text-muted">Belum ada data pesanan.</td>
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

@if(in_array(Auth::user()->role, ['ADMIN', 'KARYAWAN'], true))
<div class="modal fade" id="editOrderModal" tabindex="-1" aria-labelledby="editOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <form class="modal-content border-0 shadow" id="editOrderForm" method="POST"
            action="{{ old('order_id') ? route('orders.update', old('order_id')) : '#' }}">
            @csrf
            @method('PATCH')
            <input type="hidden" name="order_id" id="edit-order-id" value="{{ old('order_id') }}">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="editOrderModalLabel"><i class="bi bi-pencil-square me-2"></i>Edit Data Transaksi</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <div class="mb-4">
                    <label for="edit-planned-visit-date" class="form-label fw-semibold">Tanggal rencana datang</label>
                    <input type="date" class="form-control" id="edit-planned-visit-date" name="planned_visit_date" value="{{ old('planned_visit_date') }}">
                </div>
                <div class="row g-3 mb-4">
                    <div class="col-md-7">
                        <label for="edit-customer-address" class="form-label fw-semibold">Alamat pembeli</label>
                        <textarea class="form-control" id="edit-customer-address" name="customer_address" rows="2" maxlength="500">{{ old('customer_address') }}</textarea>
                    </div>
                    <div class="col-md-5">
                        <label for="edit-customer-phone" class="form-label fw-semibold">No. HP pembeli</label>
                        <input type="tel" class="form-control" id="edit-customer-phone" name="customer_phone"
                            value="{{ old('customer_phone') }}" maxlength="30" autocomplete="tel" inputmode="tel">
                    </div>
                </div>
                <label class="form-label fw-semibold">Data Resep Mata</label>
                <div class="table-responsive">
                    <table class="table table-bordered text-center align-middle">
                        <thead class="table-light">
                            <tr><th></th><th>SPH</th><th>CYL</th><th>AX</th><th>PD</th></tr>
                        </thead>
                        <tbody>
                            @foreach(['od' => 'OD', 'os' => 'OS'] as $eye => $label)
                                <tr>
                                    <th>{{ $label }}</th>
                                    @foreach(['sph' => ['SPH', '-30', '30', '0.25'], 'cyl' => ['CYL', '-30', '30', '0.25'], 'ax' => ['AX', '0', '180', '1'], 'pd' => ['PD', '0', '100', '0.5']] as $field => [$fieldLabel, $min, $max, $step])
                                        <td>
                                            <input type="number" class="form-control form-control-sm text-center"
                                                id="edit-{{ $eye }}-{{ $field }}"
                                                name="prescription[{{ $eye }}][{{ $field }}]"
                                                aria-label="{{ $label }} {{ $fieldLabel }}"
                                                value="{{ old("prescription.$eye.$field") }}"
                                                min="{{ $min }}" max="{{ $max }}" step="{{ $step }}">
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                            <tr>
                                <th>ADD</th>
                                <td colspan="4">
                                    <input type="number" class="form-control form-control-sm text-center mx-auto"
                                        id="edit-prescription-add" name="prescription[add]" aria-label="ADD"
                                        value="{{ old('prescription.add') }}"
                                        min="-30" max="30" step="0.25" style="max-width: 12rem">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <p class="small text-muted mb-0">Kolom resep boleh dikosongkan jika belum ada nilainya.</p>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endif

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

    const editOrderModal = document.getElementById('editOrderModal');
    if (editOrderModal) {
        editOrderModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            if (!button) return;

            const orderId = button.dataset.orderId;
            document.getElementById('editOrderForm').action = `/orders/${orderId}`;
            document.getElementById('edit-order-id').value = orderId;
            document.getElementById('edit-planned-visit-date').value = button.dataset.plannedVisitDate || '';
            document.getElementById('edit-customer-address').value = button.dataset.customerAddress || '';
            document.getElementById('edit-customer-phone').value = button.dataset.customerPhone || '';

            ['od', 'os'].forEach((eye) => {
                ['sph', 'cyl', 'ax', 'pd'].forEach((field) => {
                    document.getElementById(`edit-${eye}-${field}`).value = button.dataset[`${eye}${field[0].toUpperCase()}${field.slice(1)}`] || '';
                });
            });
            document.getElementById('edit-prescription-add').value = button.dataset.prescriptionAdd || '';
        });
    }

    @if($errors->any() && old('order_id'))
        document.addEventListener('DOMContentLoaded', function () {
            bootstrap.Modal.getOrCreateInstance(document.getElementById('editOrderModal')).show();
        });
    @endif
</script>
@endpush
@endsection
