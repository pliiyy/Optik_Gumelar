@extends('layouts.app')

@section('title', 'Manajemen Aksesoris')

@section('content')
<div class="container-fluid px-4">
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3">
            <h5 class="mb-0 fw-bold"><i class="bi bi-box-seam me-2"></i>Data Aksesoris</h5>
            <button class="btn btn-light btn-sm text-primary fw-semibold px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#createAccessoryModal">
                <i class="bi bi-plus-lg me-1"></i> Tambah Aksesoris
            </button>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Detail Stok</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($accessories as $accessory)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="fw-semibold text-dark">{{ $accessory->name }}</td>
                                <td>{{ $accessory->category }}</td>
                                <td>Rp {{ number_format($accessory->price, 0, ',', '.') }}</td>
                                <td>{{ $accessory->stock }}</td>
                                <td>
                                    <a href="{{ config('products.inventory_spreadsheet_url') }}" target="_blank" rel="noopener noreferrer" class="btn btn-outline-success btn-sm">
                                        <i class="bi bi-box-arrow-up-right me-1"></i>Lihat
                                    </a>
                                </td>
                                <td class="text-center text-nowrap">
                                    <button type="button" class="btn btn-outline-primary btn-sm edit-accessory me-1"
                                        data-bs-toggle="modal" data-bs-target="#editAccessoryModal"
                                        data-id="{{ $accessory->id }}"
                                        data-name="{{ $accessory->name }}"
                                        data-category="{{ $accessory->category }}"
                                        data-description="{{ $accessory->description }}"
                                        data-price="{{ $accessory->price }}"
                                        data-stock="{{ $accessory->stock }}"
                                        aria-label="Edit {{ $accessory->name }}">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-danger btn-sm delete-accessory"
                                        data-bs-toggle="modal" data-bs-target="#deleteAccessoryModal"
                                        data-id="{{ $accessory->id }}"
                                        data-name="{{ $accessory->name }}"
                                        aria-label="Hapus {{ $accessory->name }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="py-4 text-center text-muted">Belum ada data aksesoris.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="createAccessoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i>Tambah Aksesoris</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form action="{{ route('accessories.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="accessory-name" class="form-label fw-semibold">Nama Aksesoris</label>
                        <input id="accessory-name" type="text" name="name" class="form-control" maxlength="255" required>
                    </div>
                    <div class="mb-3">
                        <label for="accessory-category" class="form-label fw-semibold">Kategori</label>
                        <input id="accessory-category" type="text" name="category" class="form-control" maxlength="100" required>
                    </div>
                    <div class="mb-3">
                        <label for="accessory-description" class="form-label fw-semibold">Deskripsi</label>
                        <textarea id="accessory-description" name="description" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="accessory-price" class="form-label fw-semibold">Harga</label>
                            <input id="accessory-price" type="number" name="price" class="form-control" min="0" step="0.01" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="accessory-stock" class="form-label fw-semibold">Stok</label>
                            <input id="accessory-stock" type="number" name="stock" class="form-control" min="0" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editAccessoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title"><i class="bi bi-pencil-square me-2"></i>Edit Aksesoris</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form id="editAccessoryForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit-accessory-name" class="form-label fw-semibold">Nama Aksesoris</label>
                        <input id="edit-accessory-name" type="text" name="name" class="form-control" maxlength="255" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-accessory-category" class="form-label fw-semibold">Kategori</label>
                        <input id="edit-accessory-category" type="text" name="category" class="form-control" maxlength="100" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-accessory-description" class="form-label fw-semibold">Deskripsi</label>
                        <textarea id="edit-accessory-description" name="description" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit-accessory-price" class="form-label fw-semibold">Harga</label>
                            <input id="edit-accessory-price" type="number" name="price" class="form-control" min="0" step="0.01" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit-accessory-stock" class="form-label fw-semibold">Stok</label>
                            <input id="edit-accessory-stock" type="number" name="stock" class="form-control" min="0" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-warning">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteAccessoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form id="deleteAccessoryForm" class="modal-content border-0 shadow" method="POST">
            @csrf
            @method('DELETE')
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="bi bi-exclamation-triangle-fill me-2"></i>Hapus Aksesoris</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">Hapus data <strong id="delete-accessory-name"></strong>?</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-danger">Ya, Hapus</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.querySelectorAll('.edit-accessory').forEach(function (button) {
        button.addEventListener('click', function () {
            const id = button.dataset.id;
            document.getElementById('edit-accessory-name').value = button.dataset.name;
            document.getElementById('edit-accessory-category').value = button.dataset.category;
            document.getElementById('edit-accessory-description').value = button.dataset.description || '';
            document.getElementById('edit-accessory-price').value = button.dataset.price;
            document.getElementById('edit-accessory-stock').value = button.dataset.stock;
            document.getElementById('editAccessoryForm').action = '/accessories/' + id;
        });
    });

    document.querySelectorAll('.delete-accessory').forEach(function (button) {
        button.addEventListener('click', function () {
            const id = button.dataset.id;
            document.getElementById('delete-accessory-name').textContent = button.dataset.name;
            document.getElementById('deleteAccessoryForm').action = '/accessories/' + id;
        });
    });
</script>
@endpush
@endsection
