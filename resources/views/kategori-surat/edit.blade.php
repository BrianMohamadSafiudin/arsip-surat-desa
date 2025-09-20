@extends('layouts.app')

@section('title', 'Edit Kategori Surat - Desa Karangduren')

@section('page-title', 'Edit Kategori Surat')

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
                <h5 class="card-title mb-0">Form Edit Kategori Surat</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('kategori-surat.update', $kategoriSurat->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="nama_kategori" class="form-label">Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text"
                               class="form-control @error('nama_kategori') is-invalid @enderror"
                               id="nama_kategori"
                               name="nama_kategori"
                               value="{{ old('nama_kategori', $kategoriSurat->nama_kategori) }}"
                               placeholder="Masukkan nama kategori"
                               required>
                        @error('nama_kategori')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            <i class="fas fa-info-circle"></i>
                            ID Kategori: {{ $kategoriSurat->id }} (otomatis)
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea class="form-control @error('keterangan') is-invalid @enderror"
                                  id="keterangan"
                                  name="keterangan"
                                  rows="3"
                                  placeholder="Keterangan kategori (opsional)">{{ old('keterangan', $kategoriSurat->keterangan) }}</textarea>
                        @error('keterangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Kategori ini digunakan oleh <strong>{{ $kategoriSurat->arsipSurat()->count() }}</strong> arsip surat.
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
                                Update
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
