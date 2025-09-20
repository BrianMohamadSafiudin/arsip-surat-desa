@extends('layouts.app')

@section('title', 'About - Desa Karangduren')

@section('page-title', 'About')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-16">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="card-title mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    Tentang Aplikasi
                </h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 text-center">
                        <!-- Foto Developer -->
                        <div class="mb-3">
                            <img src="././brian.png"
                                 alt="Foto Developer"
                                 class="img-fluid"
                                 style="width: 200px; height: 200px; object-fit: cover;">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <h5 class="text-primary mb-3">Informasi Developer</h5>
                        <table class="table table-borderless">
                            <tr>
                                <td width="5%" class="fw-bold">Nama</td>
                                <td>: Brian Mohamad Safiudin</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">NIM</td>
                                <td>: 2141720133</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Email</td>
                                <td>: brianms2004@gmail.com</td>
                            </tr>
                        </table>
                        <h6 class="text-secondary">
                            Aplikasi ini dikembangkan pada tanggal 20 September 2025.
                    </div>
                </div>

                <hr class="my-4">

                <div class="row">
                    <div class="col-12">
                        <h5 class="text-primary mb-3">Tentang Aplikasi Arsip Surat</h5>
                        <p class="text-justify">
                            Aplikasi Arsip Surat Desa Karangduren adalah sistem informasi yang dikembangkan untuk membantu
                            perangkat desa dalam mengarsipkan dan mengelola surat-surat resmi yang pernah dibuat.
                            Aplikasi ini memungkinkan petugas untuk menyimpan file PDF surat hasil scan dan melakukan
                            pencarian kembali berdasarkan judul surat.
                        </p>

                        <h6 class="text-secondary mb-2">Fitur Utama:</h6>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-check text-success me-2"></i> Mengarsipkan surat dalam format PDF</li>
                            <li><i class="fas fa-check text-success me-2"></i> Kategorisasi surat (Undangan, Pengumuman, Nota Dinas, Pemberitahuan)</li>
                            <li><i class="fas fa-check text-success me-2"></i> Pencarian surat berdasarkan judul</li>
                            <li><i class="fas fa-check text-success me-2"></i> Download file PDF surat</li>
                            <li><i class="fas fa-check text-success me-2"></i> Manajemen kategori surat</li>
                            <li><i class="fas fa-check text-success me-2"></i> Interface yang user-friendly</li>
                        </ul>

                        <h6 class="text-secondary mb-2">Spesifikasi Teknis:</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <ul class="list-unstyled">
                                    <li><i class="fas fa-cog text-primary me-2"></i> Laravel 10</li>
                                    <li><i class="fas fa-database text-warning me-2"></i> MySQL Database</li>
                                    <li><i class="fas fa-code text-info me-2"></i> PHP 8.1.2</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul class="list-unstyled">
                                    <li><i class="fab fa-bootstrap text-purple me-2"></i> Bootstrap 5</li>
                                    <li><i class="fas fa-icons text-success me-2"></i> Font Awesome Icons</li>
                                    <li><i class="fas fa-mobile-alt text-danger me-2"></i> Responsive Design</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <div class="row">
                    <div class="col-12">
                        <h5 class="text-primary mb-3">Kantor Desa Karangduren</h5>
                        <div class="bg-light p-3 rounded">
                            <p class="mb-2">
                                <i class="fas fa-map-marker-alt text-danger me-2"></i>
                                <strong>Alamat:</strong> Desa Karangduren, Kecamatan Pakisaji, Kabupaten Malang
                            </p>
                            <p class="mb-2">
                                <i class="fas fa-user-tie text-primary me-2"></i>
                                <strong>Kepala Desa:</strong> Pak Syaiful (Sekretaris Desa)
                            </p>
                            <p class="mb-0">
                                <i class="fas fa-calendar text-success me-2"></i>
                                <strong>Tahun Pengembangan:</strong> {{ date('Y') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-center bg-light">
                <small class="text-muted">
                    <i class="fas fa-heart text-danger"></i>
                    Dibuat dengan sepenuh hati untuk melayani masyarakat Desa Karangduren
                </small>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.text-purple {
    color: #6f42c1 !important;
}
</style>
@endpush
