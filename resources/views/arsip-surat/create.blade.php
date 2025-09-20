@extends('layouts.app')

@section('title', 'Tambah Arsip Surat - Desa Karangduren')

@section('page-title', 'Tambah Arsip Surat')

@section('page-actions')
    <a href="{{ route('arsip-surat.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-1"></i>
        Kembali
    </a>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Form Tambah Arsip Surat</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('arsip-surat.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="nomor_surat" class="form-label">Nomor Surat <span class="text-danger">*</span></label>
                        <input type="text"
                               class="form-control @error('nomor_surat') is-invalid @enderror"
                               id="nomor_surat"
                               name="nomor_surat"
                               value="{{ old('nomor_surat') }}"
                               placeholder="Contoh: 2022/PD3/TU/001"
                               required>
                        @error('nomor_surat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="judul_surat" class="form-label">Judul Surat <span class="text-danger">*</span></label>
                        <input type="text"
                               class="form-control @error('judul_surat') is-invalid @enderror"
                               id="judul_surat"
                               name="judul_surat"
                               value="{{ old('judul_surat') }}"
                               placeholder="Masukkan judul surat"
                               required>
                        @error('judul_surat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="kategori_id" class="form-label">Kategori Surat <span class="text-danger">*</span></label>
                        <select class="form-select @error('kategori_id') is-invalid @enderror"
                                id="kategori_id"
                                name="kategori_id"
                                required>
                            <option value="">Pilih Kategori</option>
                            @foreach($kategoriSurat as $kategori)
                                <option value="{{ $kategori->id }}"
                                        {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                        @error('kategori_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="tanggal_surat" class="form-label">Tanggal Surat <span class="text-danger">*</span></label>
                        <input type="date"
                               class="form-control @error('tanggal_surat') is-invalid @enderror"
                               id="tanggal_surat"
                               name="tanggal_surat"
                               value="{{ old('tanggal_surat') }}"
                               required>
                        @error('tanggal_surat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="file" class="form-label">File PDF <span class="text-danger">*</span></label>
                        <input type="file"
                               class="form-control @error('file') is-invalid @enderror"
                               id="file"
                               name="file"
                               accept=".pdf"
                               required>
                        <div class="form-text">
                            <i class="fas fa-info-circle"></i>
                            Format yang diterima: PDF (maksimal 10MB)
                        </div>
                        @error('file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea class="form-control @error('keterangan') is-invalid @enderror"
                                  id="keterangan"
                                  name="keterangan"
                                  rows="3"
                                  placeholder="Keterangan tambahan (opsional)">{{ old('keterangan') }}</textarea>
                        @error('keterangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <a href="{{ route('arsip-surat.index') }}" class="btn btn-secondary w-100">
                                <i class="fas fa-times me-1"></i>
                                Batal
                            </a>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-save me-1"></i>
                                Simpan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Preview file name
document.getElementById('file').addEventListener('change', function(e) {
    const fileName = e.target.files[0]?.name;
    if (fileName) {
        const fileInfo = document.querySelector('.form-text');
        fileInfo.innerHTML = `<i class="fas fa-file-pdf text-danger"></i> ${fileName}`;
    }
});

// Form validation
document.querySelector('form').addEventListener('submit', function(e) {
    const fileInput = document.getElementById('file');
    const file = fileInput.files[0];

    if (file) {
        // Check file size (10MB = 10485760 bytes)
        if (file.size > 10485760) {
            e.preventDefault();
            alert('Ukuran file terlalu besar. Maksimal 10MB.');
            return false;
        }

        // Check file type
        if (file.type !== 'application/pdf') {
            e.preventDefault();
            alert('Hanya file PDF yang diperbolehkan.');
            return false;
        }
    }
});
</script>
@endpush
