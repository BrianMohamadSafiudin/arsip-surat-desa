@extends('layouts.app')

@section('title', 'Tambah Kategori Surat - Desa Karangduren')

@section('page-title', 'Tambah Kategori Surat')

@section('page-actions')
    <a href="{{ route('kategori-surat.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-1"></i>
        Kembali
    </a>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Form Tambah Kategori Surat</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('kategori-surat.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="nama_kategori" class="form-label">Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text"
                               class="form-control @error('nama_kategori') is-invalid @enderror"
                               id="nama_kategori"
                               name="nama_kategori"
                               value="{{ old('nama_kategori') }}"
                               placeholder="Masukkan nama kategori"
                               required>
                        @error('nama_kategori')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            <i class="fas fa-info-circle"></i>
                            Contoh: Undangan, Pengumuman, Nota Dinas, Pemberitahuan
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea class="form-control @error('keterangan') is-invalid @enderror"
                                  id="keterangan"
                                  name="keterangan"
                                  rows="3"
                                  placeholder="Keterangan kategori (opsional)">{{ old('keterangan') }}</textarea>
                        @error('keterangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <a href="{{ route('kategori-surat.index') }}" class="btn btn-secondary w-100">
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
