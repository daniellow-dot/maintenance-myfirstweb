<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah KK - Warga Curahgrinting</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        .form-container { background: white; border-radius: 15px; padding: 30px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .btn-custom { border-radius: 8px; padding: 10px 20px; }
        .form-label { font-weight: 600; color: #444; }
        /* Style khusus untuk kolom yang dipatenkan agar terlihat berbeda */
        .input-readonly { background-color: #e9ecef !important; border: 1px solid #ced4da !important; font-weight: 500; color: #495057; }
        .section-title { font-size: 1.1rem; color: #0d6efd; margin-top: 10px; border-bottom: 2px solid #f0f0f0; padding-bottom: 5px; }
    </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-white bg-white shadow-sm mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary" href="#">Data Warga Curahgrinting</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Beranda</a></li>
                <li class="nav-item"><a class="nav-link active fw-bold" href="data_kk.php">Data KK</a></li>
                <li class="nav-item"><a class="nav-link" href="data_warga.php">Daftar Warga</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mb-5">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="mb-3">
                <a href="data_kk.php" class="text-decoration-none text-muted"><i class="bi bi-arrow-left"></i> Kembali ke Daftar KK</a>
            </div>
            
            <div class="form-container">
                <h3 class="fw-bold mb-4">Form Tambah Kartu Keluarga</h3>
                
                <form action="proses_tambah_kk.php" method="POST">
                    <div class="row g-3">
                        <div class="col-md-6 mb-2">
                            <label class="form-label">1. Nomor Kartu Keluarga (KK)</label>
                            <input type="text" name="no_kk" class="form-control" placeholder="16 digit nomor KK" required maxlength="16">
                        </div>

                        <div class="col-md-6 mb-2">
                            <label class="form-label">2. Nama Kepala Keluarga</label>
                            <input type="text" name="kepala_keluarga" class="form-control" placeholder="Nama lengkap sesuai KTP" required>
                        </div>

                        <div class="col-12 mb-2">
                            <label class="form-label">3. Alamat Lengkap</label>
                            <textarea name="alamat" class="form-control" rows="2" placeholder="Nama jalan, dusun, atau blok" required></textarea>
                        </div>

                        <div class="col-md-4 mb-2">
                            <label class="form-label">4.a.RT</label>
                            <input type="text" name="rt" class="form-control" placeholder="001" required>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label">b.RW</label>
                            <input type="text" name="rw" class="form-control" placeholder="002" required>
                        </div>

                        <div class="col-md-4 mb-2">
                            <label class="form-label">5. Kode Pos</label>
                            <input type="number" name="kode_pos" class="form-control" value="67117">
                        </div>

                        <div class="col-12"><p class="section-title fw-bold">Informasi Wilayah (Terpatenkan)</p></div>

                        <div class="col-md-6 mb-2">
                            <label class="form-label">6.Kelurahan</label>
                            <input type="text" name="kelurahan" class="form-control input-readonly" value="Curahgrinting" readonly>
                        </div>

                        <div class="col-md-6 mb-2">
                            <label class="form-label">7. Kecamatan</label>
                            <input type="text" name="kecamatan" class="form-control input-readonly" value="Kanigaran" readonly>
                        </div>

                        <div class="col-md-6 mb-2">
                            <label class="form-label">8. Kota</label>
                            <input type="text" name="kota" class="form-control input-readonly" value="Kota Probolinggo" readonly>
                        </div>

                        <div class="col-md-6 mb-2">
                            <label class="form-label">9. Provinsi</label>
                            <input type="text" name="provinsi" class="form-control input-readonly" value="Jawa Timur" readonly>
                        </div>

                        <div class="col-md-6 mb-2">
                            <label class="form-label">10. Tanggal Terbit KK</label>
                            <input type="date" name="tgl_terbit" class="form-control shadow-sm" required>
                        </div>
                    </div>

                    <div class="mt-5 d-flex gap-2">
                        <button type="submit" name="simpan" class="btn btn-primary btn-custom flex-grow-1 shadow">
                            <i class="bi bi-save me-2"></i> Simpan Data Kartu Keluarga
                        </button>
                        <button type="reset" class="btn btn-outline-secondary btn-custom">
                            Reset Form
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>