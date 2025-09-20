@extends('layouts.app')

@section('title', 'Arsip Surat - Desa Karangduren')

@section('page-title', 'Arsip Surat')

@section('content')
<div class="row">
    <div class="col-12">
        <!-- Deskripsi -->
        <div class="mb-4">
            <p class="text-muted">
                Berikut ini adalah surat-surat yang telah terbit dan diarsipkan.<br>
                Klik "Lihat" pada kolom aksi untuk menampilkan surat.
            </p>
        </div>

        <!-- Search Form -->
        <div class="row mb-3">
            <div class="col-md-8">
                <form method="GET" action="{{ route('arsip-surat.index') }}" class="d-flex">
                    <label class="me-2 align-self-center">Cari surat:</label>
                    <input type="text"
                           class="form-control me-2"
                           name="search"
                           placeholder="search"
                           value="{{ request('search') }}"
                           style="max-width: 300px;">
                    <button class="btn btn-outline-secondary" type="submit">Cari!</button>
                </form>
            </div>
        </div>

        <!-- Data Table -->
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Nomor Surat</th>
                        <th>Kategori</th>
                        <th>Judul</th>
                        <th>Waktu Pengarsipan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if($arsipSurat->count() > 0)
                        @foreach($arsipSurat as $item)
                            <tr>
                                <td>{{ $item->nomor_surat ?? '-' }}</td>
                                <td>{{ $item->kategori->nama_kategori }}</td>
                                <td>{{ $item->judul_surat }}</td>
                                <td>{{ $item->created_at->setTimezone('Asia/Jakarta')->format('Y-m-d H:i') }}</td>
                                <td>
                                    <button type="button"
                                            class="btn btn-sm btn-danger me-1"
                                            onclick="confirmDelete({{ $item->id }}, '{{ $item->judul_surat }}')">
                                        Hapus
                                    </button>
                                    <a href="{{ route('arsip-surat.download', $item->id) }}"
                                       class="btn btn-sm btn-warning me-1 download-btn"
                                       data-filename="{{ $item->nomor_surat }} - {{ $item->judul_surat }}.pdf">
                                        Unduh
                                    </a>
                                    <a href="{{ route('arsip-surat.show', $item->id) }}"
                                       class="btn btn-sm btn-primary">
                                        Lihat >>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" class="text-center">
                                @if(request('search'))
                                    Tidak ditemukan data dengan kata kunci "{{ request('search') }}"
                                @else
                                    Tidak ada data arsip surat
                                @endif
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($arsipSurat->hasPages())
            <div class="d-flex justify-content-center mt-3">
                {{ $arsipSurat->appends(request()->input())->links() }}
            </div>
        @endif

        <!-- Tombol Arsipkan Surat -->
        <div class="mt-3">
            <a href="{{ route('arsip-surat.create') }}" class="btn btn-secondary">
                Arsipkan Surat...
            </a>
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
                <p>Apakah Anda yakin ingin menghapus surat:</p>
                <p class="fw-bold" id="deleteItemTitle"></p>
                <p class="text-danger small">Data yang dihapus tidak dapat dikembalikan!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Ya!</button>
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
    document.getElementById('deleteForm').action = '/arsip-surat/' + id;

    var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
}

// Handler untuk tombol download - Force Save As Dialog
document.addEventListener('DOMContentLoaded', function() {
    const downloadButtons = document.querySelectorAll('.download-btn');

    downloadButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();

            const url = this.href;
            const filename = this.getAttribute('data-filename') || 'document.pdf';

            // Coba gunakan showSaveFilePicker jika tersedia (Chrome modern)
            if (window.showSaveFilePicker) {
                fetch(url)
                .then(response => response.blob())
                .then(async blob => {
                    try {
                        const fileHandle = await window.showSaveFilePicker({
                            suggestedName: filename,
                            types: [{
                                description: 'PDF files',
                                accept: { 'application/pdf': ['.pdf'] }
                            }]
                        });
                        const writable = await fileHandle.createWritable();
                        await writable.write(blob);
                        await writable.close();
                        console.log('File berhasil disimpan');
                    } catch (err) {
                        if (err.name === 'AbortError') {
                            console.log('User membatalkan download');
                            return; // Stop di sini, jangan fallback
                        }
                        // Jika error lain, fallback ke download biasa
                        window.location.href = url;
                    }
                })
                .catch(() => {
                    // Jika fetch gagal, fallback ke download biasa
                    window.location.href = url;
                });
            } else {
                // Browser lama, langsung download biasa
                window.location.href = url;
            }
        });
    });
});
</script>
@endpush
