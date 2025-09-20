# Aplikasi Arsip Surat Desa Karangduren

Aplikasi arsip surat digital untuk Desa Karangduren, Kecamatan Pakisaji yang memungkinkan perangkat desa untuk mengarsipkan dan mengelola surat-surat resmi dalam format PDF.

- File Database terdapat di folder `database/arsip_surat_desa.sql`
- Tampilan dapat dilihat di folder `screenshots/` atau pada bagian akhir README.

## 🏛️ Tentang Desa Karangduren

**Desa Karangduren** adalah sebuah desa yang terletak di Kecamatan Pakisaji yang membutuhkan sistem pengarsipan digital untuk mengelola surat-surat resmi yang dibuat oleh perangkat desa. Aplikasi ini dikembangkan atas permintaan **Pak Syaiful** selaku Sekretaris Desa.

## ✨ Fitur Utama

### 🏠 **Halaman Dashboard**
- Tampilan ringkasan statistik arsip surat
- Total surat yang telah diarsipkan
- Navigasi cepat ke fitur-fitur utama aplikasi
- Interface yang user-friendly dengan tema desa

### 📋 **Halaman Daftar Arsip Surat**
- **Pencarian Surat**: Fitur pencarian berdasarkan nomor surat, judul, atau kategori
- **Filter Kategori**: Filter surat berdasarkan kategori yang telah ditentukan
- **Tabel Data**: Menampilkan daftar surat dengan kolom:
  - Nomor Surat
  - Kategori
  - Judul Surat  
  - Tanggal Diarsipkan (otomatis menggunakan timezone Jakarta WIB)
- **Aksi pada Setiap Surat**:
  - Tombol **Lihat >>**: Melihat detail dan preview PDF surat
  - Tombol **Hapus**: Menghapus arsip surat (dengan konfirmasi)

### 👀 **Halaman Detail Arsip Surat**
- **Panel Informasi Surat** (Kolom Kiri):
  - Nomor Surat
  - Judul Surat
  - Kategori (dengan badge warna)
  - Tanggal Surat
  - Tanggal Diarsipkan
  - Keterangan (jika ada)
- **Preview PDF** (Kolom Kanan):
  - Tampilan langsung file PDF dalam browser
  - Toolbar PDF disembunyikan untuk tampilan yang bersih
  - Responsive design yang menyesuaikan ukuran layar
- **Tombol Aksi**:
  - **Kembali**: Kembali ke daftar arsip
  - **Unduh**: Download file PDF dengan dialog "Save As" untuk memilih lokasi penyimpanan
  - **Edit**: Mengedit data arsip surat
  - **Hapus**: Menghapus arsip (dengan konfirmasi)

### ➕ **Halaman Tambah Arsip Surat**
- **Form Input Lengkap**:
  - Nomor Surat (wajib)
  - Judul Surat (wajib)
  - Kategori Surat (dropdown, wajib)
  - Tanggal Surat (date picker, wajib)
  - Upload File PDF (drag & drop support, maksimal 10MB)
  - Keterangan (opsional)
- **Validasi Form**: Validasi real-time untuk semua input
- **Upload Security**: Hanya menerima file PDF dengan validasi server-side

### ✏️ **Halaman Edit Arsip Surat**
- Form yang sama dengan tambah arsip, namun sudah terisi data existing
- Opsi untuk mengganti file PDF atau mempertahankan file lama
- Preview data lama sebelum disimpan perubahan

### 🏷️ **Halaman Kelola Kategori Surat**
- **Daftar Kategori**: Menampilkan semua kategori yang tersedia
- **Tambah Kategori Baru**: Form untuk menambah kategori surat
- **Edit Kategori**: Mengubah nama atau keterangan kategori
- **Hapus Kategori**: Menghapus kategori (dengan validasi penggunaan)

### ℹ️ **Halaman Tentang**
- Informasi lengkap tentang aplikasi
- Tujuan dan manfaat aplikasi untuk desa
- Informasi pengembang dan kontak

## 🔧 Teknologi yang Digunakan

- **Backend**: Laravel 10 (PHP 8.1.2)
- **Database**: MySQL
- **Frontend**: Bootstrap 5, Font Awesome Icons
- **File Storage**: Laravel Storage (Public Disk)
- **PDF Handling**: Browser Native PDF Viewer dengan Custom Controls

## 📋 Prasyarat Sistem

Sebelum menjalankan aplikasi, pastikan sistem Anda memiliki:

- **PHP**: Versi 8.1.2 atau lebih tinggi
- **Composer**: Package manager untuk PHP
- **MySQL**: Database server
- **Web Server**: Apache/Nginx atau Laravel Development Server
- **Extension PHP yang dibutuhkan**:
  - PDO MySQL
  - Mbstring
  - OpenSSL
  - Tokenizer
  - XML
  - Ctype
  - JSON

## 🚀 Cara Menjalankan Aplikasi

### 1. **Clone atau Download Project**
```bash
git clone <repository-url>
cd arsip-surat-desa
```

### 2. **Install Dependencies**
```bash
composer install
```

### 3. **Konfigurasi Environment**
```bash
# Copy file environment
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. **Konfigurasi Database**
Edit file `.env` dan sesuaikan konfigurasi database:
```env
APP_NAME="Arsip Surat Desa Karangduren"
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=arsip_surat_desa
DB_USERNAME=root
DB_PASSWORD=
```

### 5. **Buat Database**
Buat database MySQL dengan nama `arsip_surat_desa` atau sesuai yang Anda set di `.env`

### 6. **Jalankan Migration dan Seeder**
```bash
# Jalankan migration untuk membuat tabel
php artisan migrate

# Jalankan seeder untuk data awal (opsional)
php artisan db:seed
```

### 7. **Buat Storage Link**
```bash
php artisan storage:link
```

### 8. **Jalankan Aplikasi**
```bash
php artisan serve
```
Aplikasi akan berjalan di: `http://localhost:8000`

## 📂 Struktur Database

### Tabel `kategori_surat`
| Field | Type | Description |
|-------|------|-------------|
| id | bigint | Primary key (auto increment) |
| nama_kategori | varchar(255) | Nama kategori surat |
| keterangan | text | Keterangan kategori (nullable) |
| created_at | timestamp | Waktu dibuat |
| updated_at | timestamp | Waktu diupdate |

### Tabel `arsip_surat`
| Field | Type | Description |
|-------|------|-------------|
| id | bigint | Primary key (auto increment) |
| nomor_surat | varchar(255) | Nomor surat resmi |
| judul_surat | varchar(255) | Judul surat |
| kategori_id | bigint | Foreign key ke kategori_surat |
| tanggal_surat | date | Tanggal surat dibuat |
| file_path | varchar(255) | Path file PDF |
| keterangan | text | Keterangan tambahan (nullable) |
| created_at | timestamp | Waktu diarsipkan |
| updated_at | timestamp | Waktu diupdate |

## 🎨 Tampilan Aplikasi

### Halaman Utama
- Menampilkan daftar arsip surat dalam bentuk tabel
- Kolom: Nomor Surat, Kategori, Judul, Waktu Pengarsipan, Aksi
- Fitur pencarian berdasarkan judul surat
- Tombol aksi: Hapus, Unduh, Lihat >>

### Menu Navigasi
- **Arsip**: Halaman utama untuk melihat dan mengelola arsip surat
- **Kategori Surat**: Halaman untuk mengelola kategori surat
- **About**: Informasi tentang aplikasi dan developer

### Form Input
- Form untuk tambah/edit arsip surat dengan upload PDF
- Validasi file: hanya menerima format PDF dengan maksimal 10MB
- Dropdown kategori surat yang dinamis

## 🔧 Spesifikasi Teknis

- **Framework**: Laravel 10
- **Database**: MySQL
- **PHP Version**: 8.1.2
- **Frontend**: Bootstrap 5, Font Awesome Icons
- **File Upload**: Laravel Storage dengan disk 'public'
- **Validation**: Laravel Form Request Validation

## 👥 Tim Pengembang

- **Developer**: Brian Mohamad Safiudin
- **NIM**: 2141720133
- **Email**: brianms2004@gmail.com  
- **Tanggal Pembuatan**: 20 September 2025

## 📞 Kontak

**Kantor Desa Karangduren**  
Desa Karangduren, Kecamatan Pakisaji, Kabupaten Malang  
**Kepala Desa**: Pak Syaiful (Sekretaris Desa)

## 📄 Lisensi

Aplikasi ini dikembangkan khusus untuk Desa Karangduren dalam rangka digitalisasi pengelolaan surat resmi desa.

---

*Dibuat dengan ❤️ untuk melayani masyarakat Desa Karangduren*

## 📸 Screenshots

### Daftar Arsip Surat
![Tampilan Daftar Arsip Surat](/screenshots/DaftarArsip.png)

### Detail Arsip dengan PDF Preview
![Tampilan Detail Arsip](/screenshots/DetailArsip.png)

### Form Tambah Arsip
![Tampilan Form Tambah Arsip](/screenshots/TambahArsip.png)

## Form Edit Arsip
![Tampilan Form Edit Arsip](/screenshots/EditArsip.png)

### Kelola Kategori
![Tampilan Kelola Kategori](/screenshots/DaftarKategori.png)

### Form Tambah Kategori
![Tampilan Form Tambah Kategori](/screenshots/TambahKategori.png)

### Form Edit Kategori
![Tampilan Form Edit Kategori](/screenshots/EditKategori.png)

### Tentang Aplikasi
![Tampilan Tentang Aplikasi](/screenshots/TentangAplikasi.png)
