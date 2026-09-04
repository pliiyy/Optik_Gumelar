@extends('layouts.app')

@section('title', 'Manajemen Frame')

@section('content')
<div class="container-fluid px-4">
    <div class="row justify-content-center">
        <div class="col-lg-12 content">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-eyeglasses me-2"></i>Data Frame</h5>
                    <button class="btn btn-light btn-sm text-primary fw-semibold px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#createFrameModal">
                        <i class="bi bi-plus-lg me-1"></i> Tambah Frame
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">#</th>
                                    <th>Nama</th>
                                    <th>Kategori</th>
                                    <th>Harga</th>
                                    <th>Stok</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($frames as $frame)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="fw-semibold text-dark">{{ $frame->name }}</td>
                                        <td>{{ $frame->category }}</td>
                                        <td>Rp {{ number_format($frame->price, 0, ',', '.') }}</td>
                                        <td>{{ $frame->stock }}</td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-outline-primary btn-sm btn-edit-frame me-1" data-bs-toggle="modal" data-bs-target="#editFrameModal" data-id="{{ $frame->id }}" data-name="{{ $frame->name }}" data-category="{{ $frame->category }}" data-description="{{ $frame->description }}" data-price="{{ $frame->price }}" data-stock="{{ $frame->stock }}">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                            <button type="button" class="btn btn-outline-danger btn-sm btn-delete-frame" data-bs-toggle="modal" data-bs-target="#deleteFrameModal" data-id="{{ $frame->id }}" data-name="{{ $frame->name }}">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-muted">
                                            <p class="mb-0">Belum ada data frame tersedia.</p>
                                        </td>
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

<div class="modal fade" id="createFrameModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i>Tambah Data Frame</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('frames.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Frame</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kategori</label>
                        <input type="text" name="category" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Deskripsi</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Harga</label>
                            <input type="number" name="price" class="form-control" min="0" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Stok</label>
                            <input type="number" name="stock" class="form-control" min="0" required>
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

<div class="modal fade" id="editFrameModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title"><i class="bi bi-pencil-square me-2"></i>Edit Data Frame</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editFrameForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Frame</label>
                        <input type="text" name="name" id="edit-frame-name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kategori</label>
                        <input type="text" name="category" id="edit-frame-category" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Deskripsi</label>
                        <textarea name="description" id="edit-frame-description" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Harga</label>
                            <input type="number" name="price" id="edit-frame-price" class="form-control" min="0" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Stok</label>
                            <input type="number" name="stock" id="edit-frame-stock" class="form-control" min="0" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-warning text-dark fw-semibold">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteFrameModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content border-0 shadow" id="deleteFrameForm" method="POST">
            @csrf
            @method('DELETE')
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="bi bi-exclamation-triangle-fill me-2"></i>Konfirmasi Hapus</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center py-4">
                <p class="mb-1">Apakah Anda yakin ingin menghapus frame:</p>
                <h5 class="fw-bold text-dark" id="delete-frame-name"></h5>
            </div>
            <div class="modal-footer bg-light justify-content-center">
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-danger px-4">Ya, Hapus</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function () {
        $('.btn-edit-frame').on('click', function () {
            const id = $(this).data('id');
            $('#edit-frame-name').val($(this).data('name'));
            $('#edit-frame-category').val($(this).data('category'));
            $('#edit-frame-description').val($(this).data('description'));
            $('#edit-frame-price').val($(this).data('price'));
            $('#edit-frame-stock').val($(this).data('stock'));
            $('#editFrameForm').attr('action', '/frames/' + id);
        });

        $('.btn-delete-frame').on('click', function () {
            const id = $(this).data('id');
            $('#delete-frame-name').text($(this).data('name'));
            $('#deleteFrameForm').attr('action', '/frames/' + id);
        });
    });
</script>
@endpush
@endsection
