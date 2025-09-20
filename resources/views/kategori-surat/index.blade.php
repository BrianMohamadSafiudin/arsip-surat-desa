@extends('layouts.app')

@section('title', 'Kategori Surat - Desa Karangduren')

@section('page-title', 'Kategori Surat')

@section('page-actions')
    <a href="{{ route('kategori-surat.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i>
        Tambah
    </a>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Daftar Kategori Surat</h5>
            </div>
            <div class="card-body">
                @if($kategoriSurat->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="25%">Nama Kategori</th>
                                    <th width="40%">Keterangan</th>
                                    <th width="15%">Jumlah Surat</th>
                                    <th width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($kategoriSurat as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <strong>{{ $item->nama_kategori }}</strong>
                                        </td>
                                        <td>{{ $item->keterangan ?? '-' }}</td>
                                        <td>
                                            <span class="badge bg-secondary">{{ $item->arsip_surat_count }} surat</span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('kategori-surat.edit', $item->id) }}"
                                                   class="btn btn-sm btn-warning"
                                                   title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                @if($item->arsip_surat_count == 0)
                                                    <button type="button"
                                                            class="btn btn-sm btn-danger"
                                                            title="Hapus"
                                                            onclick="confirmDelete({{ $item->id }}, '{{ $item->nama_kategori }}')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                @else
                                                    <button type="button"
                                                            class="btn btn-sm btn-secondary"
                                                            title="Tidak dapat dihapus karena masih digunakan"
                                                            disabled>
                                                        <i class="fas fa-lock"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-tags fa-4x text-muted mb-3"></i>
                        <h5 class="text-muted">Tidak ada kategori surat</h5>
                        <p class="text-muted">Mulai tambahkan kategori surat pertama Anda</p>
                        <a href="{{ route('kategori-surat.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i>
                            Tambah Kategori Sekarang
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus kategori:</p>
                <p class="fw-bold" id="deleteItemTitle"></p>
                <p class="text-danger small">Data yang dihapus tidak dapat dikembalikan!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Ya, Hapus!</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function confirmDelete(id, title) {
    document.getElementById('deleteItemTitle').textContent = title;
    document.getElementById('deleteForm').action = '/kategori-surat/' + id;

    var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
}
</script>
@endpush
