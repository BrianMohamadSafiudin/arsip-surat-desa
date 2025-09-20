@extends('layouts.app')

@section('title', 'Detail Arsip Surat - Desa Karangduren')

@section('page-title', 'Detail Arsip Surat')

@section('content')
<div class="row">
    <!-- Informasi Surat - Kolom Kiri -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h6 class="card-title mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    Informasi Surat
                </h6>
            </div>
            <div class="card-body">
                <table class="table table-sm table-borderless">
                    <tr>
                        <td class="fw-bold">Nomor Surat:</td>
                    </tr>
                    <tr>
                        <td class="pb-2">{{ $arsipSurat->nomor_surat }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Judul Surat:</td>
                    </tr>
                    <tr>
                        <td class="pb-2">{{ $arsipSurat->judul_surat }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Kategori:</td>
                    </tr>
                    <tr>
                        <td class="pb-2">
                            <span class="badge bg-info">{{ $arsipSurat->kategori->nama_kategori }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Tanggal Surat:</td>
                    </tr>
                    <tr>
                        <td class="pb-2">{{ $arsipSurat->tanggal_surat->format('d F Y') }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Tanggal Diarsipkan:</td>
                    </tr>
                    <tr>
                        <td class="pb-2">{{ $arsipSurat->created_at->setTimezone('Asia/Jakarta')->format('d F Y H:i') }} WIB</td>
                    </tr>
                    @if($arsipSurat->keterangan)
                    <tr>
                        <td class="fw-bold">Keterangan:</td>
                    </tr>
                    <tr>
                        <td class="pb-2">{{ $arsipSurat->keterangan }}</td>
                    </tr>
                    @endif
                </table>

                <!-- Tombol Aksi -->
                <div class="d-grid gap-2 mt-3">
                    <a href="{{ route('arsip-surat.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i>
                        Kembali
                    </a>
                    <a href="{{ route('arsip-surat.download', $arsipSurat->id) }}"
                       class="btn btn-success download-btn"
                       data-filename="{{ $arsipSurat->nomor_surat }} - {{ $arsipSurat->judul_surat }}.pdf">
                        <i class="fas fa-download me-1"></i>
                        Unduh
                    </a>
                    <a href="{{ route('arsip-surat.edit', $arsipSurat->id) }}"
                       class="btn btn-warning">
                        <i class="fas fa-edit me-1"></i>
                        Edit
                    </a>
                    <button type="button"
                            class="btn btn-danger"
                            onclick="confirmDelete({{ $arsipSurat->id }}, '{{ $arsipSurat->judul_surat }}')">
                        <i class="fas fa-trash me-1"></i>
                        Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- PDF Viewer - Kolom Kanan -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-secondary text-white">
                <h6 class="card-title mb-0">
                    <i class="fas fa-file-pdf me-2"></i>
                    Preview Surat: {{ basename($arsipSurat->file_path) }}
                </h6>
            </div>
            <div class="card-body p-0">
                <div id="pdfContainer" style="height: 600px; border: 1px solid #ddd; overflow: hidden;">
                    @php
                        $filePath = storage_path('app/public/' . $arsipSurat->file_path);
                        $fileExists = file_exists($filePath);
                    @endphp

                    @if($fileExists)
                        <!-- Menggunakan object untuk tampilan PDF yang lebih bersih -->
                        <object
                            data="{{ asset('storage/' . $arsipSurat->file_path) }}#toolbar=0&navpanes=0&scrollbar=0&view=FitH"
                            type="application/pdf"
                            width="100%"
                            height="100%"
                            style="border: none;">

                            <!-- Fallback ke iframe jika object tidak didukung -->
                            <iframe
                                src="{{ asset('storage/' . $arsipSurat->file_path) }}#toolbar=0&navpanes=0&scrollbar=0&view=FitH"
                                width="100%"
                                height="100%"
                                style="border: none;"
                                frameborder="0">

                                <!-- Fallback terakhir jika iframe juga tidak didukung -->
                                <div class="d-flex align-items-center justify-content-center h-100">
                                    <div class="text-center text-muted">
                                        <i class="fas fa-file-pdf fa-4x mb-3"></i>
                                        <h5>Browser tidak mendukung tampilan PDF</h5>
                                        <p>Silakan download file untuk melihat isinya</p>
                                        <a href="{{ route('arsip-surat.download', $arsipSurat->id) }}" class="btn btn-success">
                                            <i class="fas fa-download me-1"></i>
                                            Download PDF
                                        </a>
                                    </div>
                                </div>
                            </iframe>
                        </object>
                    @else
                        <div class="d-flex align-items-center justify-content-center h-100">
                            <div class="text-center text-muted">
                                <i class="fas fa-file-pdf fa-4x mb-3"></i>
                                <h5>File tidak ditemukan</h5>
                                <p>File PDF mungkin telah dipindah atau dihapus</p>
                                <a href="{{ route('arsip-surat.edit', $arsipSurat->id) }}"
                                   class="btn btn-warning">
                                    Upload Ulang File
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
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
<style>
/* CSS untuk menyembunyikan kontrol PDF browser */
#pdfContainer object,
#pdfContainer iframe {
    pointer-events: auto;
}

/* Menyembunyikan toolbar PDF jika muncul */
#pdfContainer .pdf-viewer-toolbar,
#pdfContainer .toolbar,
#pdfContainer .findbar {
    display: none !important;
    visibility: hidden !important;
}

/* Memastikan PDF mengisi penuh container */
#pdfContainer {
    position: relative;
    overflow: hidden;
}
</style>

<script>
function confirmDelete(id, title) {
    document.getElementById('deleteItemTitle').textContent = title;
    document.getElementById('deleteForm').action = '/arsip-surat/' + id;

    var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
}

// PDF Loading Handler
document.addEventListener('DOMContentLoaded', function() {
    const pdfContainer = document.getElementById('pdfContainer');
    const pdfObject = pdfContainer ? pdfContainer.querySelector('object') : null;
    const pdfIframe = pdfContainer ? pdfContainer.querySelector('iframe') : null;

    // Sederhana: Handler untuk tombol download
    const downloadButton = document.querySelector('.download-btn');
    if (downloadButton) {
        downloadButton.addEventListener('click', function(e) {
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
    }

    // Coba sembunyikan kontrol dengan JavaScript
    function hidePdfControls() {
        try {
            // Untuk object element
            if (pdfObject && pdfObject.contentDocument) {
                const pdfDoc = pdfObject.contentDocument;
                const toolbar = pdfDoc.querySelector('#toolbar, .toolbar, .findbar');
                if (toolbar) {
                    toolbar.style.display = 'none';
                }
            }

            // Untuk iframe element
            if (pdfIframe && pdfIframe.contentDocument) {
                const pdfDoc = pdfIframe.contentDocument;
                const toolbar = pdfDoc.querySelector('#toolbar, .toolbar, .findbar');
                if (toolbar) {
                    toolbar.style.display = 'none';
                }
            }
        } catch (e) {
            // Cross-origin restrictions, tidak apa-apa
            console.log('Cannot access PDF controls due to cross-origin restrictions');
        }
    }

    // Coba sembunyikan kontrol dengan JavaScript
    function hidePdfControls() {
        try {
            // Untuk object element
            if (pdfObject && pdfObject.contentDocument) {
                const pdfDoc = pdfObject.contentDocument;
                const toolbar = pdfDoc.querySelector('#toolbar, .toolbar, .findbar');
                if (toolbar) {
                    toolbar.style.display = 'none';
                }
            }

            // Untuk iframe element
            if (pdfIframe && pdfIframe.contentDocument) {
                const pdfDoc = pdfIframe.contentDocument;
                const toolbar = pdfDoc.querySelector('#toolbar, .toolbar, .findbar');
                if (toolbar) {
                    toolbar.style.display = 'none';
                }
            }
        } catch (e) {
            // Cross-origin restrictions, tidak apa-apa
            console.log('Cannot access PDF controls due to cross-origin restrictions');
        }
    }

    if (pdfObject) {
        pdfObject.addEventListener('load', function() {
            console.log('PDF loaded successfully via object');
            setTimeout(hidePdfControls, 1000);
        });

        pdfObject.addEventListener('error', function() {
            console.log('Error loading PDF via object');
        });
    }

    if (pdfIframe) {
        pdfIframe.addEventListener('load', function() {
            console.log('PDF loaded successfully via iframe');
            setTimeout(hidePdfControls, 1000);
        });

        pdfIframe.addEventListener('error', function() {
            console.log('Error loading PDF');
            if (pdfContainer) {
                pdfContainer.innerHTML =
                    '<div class="d-flex align-items-center justify-content-center h-100">' +
                    '<div class="text-center text-muted">' +
                    '<i class="fas fa-exclamation-triangle fa-4x mb-3"></i>' +
                    '<h5>Tidak dapat memuat PDF</h5>' +
                    '<p>Silakan download file untuk melihat isinya</p>' +
                    '<a href="{{ route("arsip-surat.download", $arsipSurat->id) }}" class="btn btn-success">Download PDF</a>' +
                    '</div></div>';
            }
        });
    }
});
</script>
@endpush
