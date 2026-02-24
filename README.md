# Maintenance MyFirstWeb - Sistem Administrasi Kependudukan

> Sistem manajemen data kependudukan untuk RT/RW Curahgrinting dengan fitur input data warga, manajemen kartu keluarga, dan pembuatan laporan bulanan Ketua RT/RW.

## 📋 Fitur Utama

- ✅ **Input Data Warga** - Tambah data warga dengan informasi lengkap
- ✅ **Manajemen Kartu Keluarga (KK)** - Kelola data KK dan anggota keluarga
- ✅ **Edit Data** - Perbarui informasi warga dan KK
- ✅ **Hapus Data** - Hapus data warga atau KK yang sudah tidak berlaku
- ✅ **Pencarian & Filter** - Cari warga berdasarkan nama, NIK, atau No. KK
- ✅ **Filter Wilayah** - Filter data berdasarkan RT/RW
- ✅ **Laporan Bulanan** - Buat laporan bulanan untuk Ketua RT/RW
- ✅ **Cetak Data** - Print data warga dan KK untuk dokumentasi

## 🛠️ Tech Stack

- **Backend:** PHP 7.x+
- **Database:** MySQL
- **Frontend:** HTML5, CSS3, Bootstrap 5.3
- **Icons:** Bootstrap Icons 1.11
- **Font:** Plus Jakarta Sans

## 📁 Struktur Folder

```
/htdocs
├── index.php                    # Halaman login
├── dashboard.php               # Halaman utama (setelah login)
├── data_warga.php             # Daftar data warga
├── data_kk.php                # Daftar kartu keluarga
├── tambah_data_warga.php      # Form tambah warga
├── tambah_kk.php              # Form tambah KK
├── edit_warga.php             # Form edit data warga
├── edit_kk.php                # Form edit KK
├── hapus_warga.php            # Proses hapus data warga
├── hapus_kk.php               # Proses hapus KK
├── proses_tambah_warga.php    # Proses insert warga
├── proses_tambah_kk.php       # Proses insert KK
├── cetak_laporan.php          # Cetak laporan bulanan
├── download_laporan.php       # Download laporan
├── laporan_rt.php             # Laporan RT/RW
├── koneksi.php                # Konfigurasi database
├── navbar.php                 # Komponen navbar
├── header.php                 # Komponen header
├── login.php                  # Proses login
├── logout.php                 # Proses logout
├── register.php               # Registrasi user baru
├── kontak.php                 # Halaman kontak
├── bantuan_password.php       # Reset password
├── assets/                    # CSS, JS, Images
├── uploads/                   # Folder upload dokumen
└── db/                        # Database backups
```

## 🚀 Instalasi & Setup

### Prerequisites
- PHP 7.4 atau lebih tinggi
- MySQL 5.7 atau lebih tinggi
- Web Server (Apache/Nginx)

### Langkah-langkah Install

1. **Clone Repository**
```bash
git clone https://github.com/daniellow-dot/maintenance-myfirstweb.git
cd maintenance-myfirstweb
```

2. **Setup Database**
- Import file database (jika ada)
- Atau buat database baru dengan nama: `if0_40660615_curah`

3. **Konfigurasi Koneksi**
Edit file `koneksi.php`:
```php
$koneksi = mysqli_connect("localhost", "username", "password", "database_name");
```

4. **Akses Website**
```
http://localhost/maintenance-myfirstweb/
```

## 📝 Changelog

### Version 1.0.0 (Initial Release)
- ✅ Fitur input data warga
- ✅ Fitur manajemen KK
- ✅ Edit & hapus data
- ✅ Pencarian & filter
- ✅ Laporan bulanan
- ✅ Cetak data

### Bug Fixes (Latest)
- 🔧 Fixed: Edit data warga link error (404)
- 🔧 Fixed: Hapus warga menggunakan id_warga (bukan no_kk)
- ✨ Added: File `edit_warga.php` untuk edit data warga individual
- ✨ Added: File `hapus_warga.php` untuk hapus data warga individual

## 🐛 Known Issues

_Tidak ada issue yang diketahui saat ini._

## 📚 Dokumentasi Fitur

### Edit Data Warga
- **File:** `edit_warga.php`
- **Fungsi:** Edit informasi lengkap seorang warga
- **Parameter:** `id` (id_warga)
- **Fields:** Nama, NIK, Jenis Kelamin, Agama, Tempat/Tgl Lahir, Pendidikan, Pekerjaan, Status Perkawinan, Status Hubungan, Data Orang Tua, Dokumen Identitas, Kewarganegaraan

### Hapus Data Warga
- **File:** `hapus_warga.php`
- **Fungsi:** Menghapus data warga dari database
- **Parameter:** `id` (id_warga)
- **Konfirmasi:** Ada dialog konfirmasi sebelum hapus

## 🤝 Kontribusi

Anda dapat berkontribusi dengan:

1. Fork repository ini
2. Buat branch fitur baru (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buka Pull Request

## 📄 Lisensi

Project ini adalah properti dari Desa Curahgrinting. Penggunaan dan distribusi harus mendapat izin dari administrator.

## 👨‍💼 Maintainer

- **Primary Developer:** curahgtr
- **Maintenance:** daniellow-dot

## 📞 Kontak & Support

Untuk pertanyaan atau support:
- Email: [support@curahgrinting.local]
- Halaman Kontak: `/kontak.php`
- Bantuan: `/bantuan_password.php`

---

**Last Updated:** 2026-02-24

**Desa Curahgrinting - Sistem Administrasi Kependudukan** ©2026
