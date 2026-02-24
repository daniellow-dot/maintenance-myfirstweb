<?php 
include 'koneksi.php';
$query_kk = mysqli_query($koneksi, "SELECT no_kk, kepala_keluarga FROM data_kk ORDER BY kepala_keluarga ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Warga Lengkap - Curahgrinting</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .form-section { background: #f8f9fa; padding: 15px; border-radius: 10px; margin-bottom: 20px; border-left: 5px solid #0d6efd; }
        .section-title { font-weight: bold; color: #0d6efd; margin-bottom: 15px; text-transform: uppercase; font-size: 0.9rem; }
    </style>
</head>
<body class="bg-light">
<div class="container mt-4 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow border-0">
                <div class="card-body p-4">
                    <h3 class="fw-bold mb-4 text-center">Formulir Data Anggota Keluarga</h3>
                    <form action="proses_tambah_warga.php" method="POST">
                        
                        <div class="form-section">
                            <div class="section-title">Hubungan Kartu Keluarga</div>
                            <div class="row g-3">
                                <div class="col-md-8">
                                    <label class="form-label fw-semibold">Pilih Kartu Keluarga (KK)</label>
                                    <select name="no_kk" class="form-select" required>
                                        <option value="">-- Cari KK / Kepala Keluarga --</option>
                                        <?php while($kk = mysqli_fetch_assoc($query_kk)): ?>
                                            <option value="<?= $kk['no_kk']; ?>"><?= $kk['no_kk']; ?> - <?= strtoupper($kk['kepala_keluarga']); ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Status Hubungan</label>
                                    <select name="status_hubungan" class="form-select" required>
                                        <option value="KEPALA KELUARGA">KEPALA KELUARGA</option>
                                        <option value="ISTRI">ISTRI</option>
                                        <option value="ANAK">ANAK</option>
                                        <option value="MENANTU">MENANTU</option>
                                        <option value="CUCU">CUCU</option>
                                        <option value="ORANG TUA">ORANG TUA</option>
                                        <option value="MERTUA">MERTUA</option>
                                        <option value="LAINNYA">LAINNYA</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-section">
                            <div class="section-title">Identitas Pribadi</div>
                            <div class="row g-3">
                                <div class="col-md-8">
                                    <label class="form-label">Nama Lengkap</label>
                                    <input type="text" name="nama_lengkap" class="form-control" placeholder="Sesuai KTP/Akte" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">NIK</label>
                                    <input type="text" name="nik" class="form-control" maxlength="16" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Jenis Kelamin</label>
                                    <select name="jenis_kelamin" class="form-select">
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Tempat Lahir</label>
                                    <input type="text" name="tempat_lahir" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Tanggal Lahir</label>
                                    <input type="date" name="tgl_lahir" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Agama</label>
                                    <select name="agama" class="form-select">
                                        <option value="ISLAM">ISLAM</option>
                                        <option value="KRISTEN">KRISTEN</option>
                                        <option value="KATHOLIK">KATHOLIK</option>
                                        <option value="HINDU">HINDU</option>
                                        <option value="BUDHA">BUDHA</option>
                                        <option value="KHONGHUCU">KHONGHUCU</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Pendidikan</label>
                                    <input type="text" name="pendidikan" class="form-control" placeholder="Contoh: S1 Teknik">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Jenis Pekerjaan</label>
                                    <input type="text" name="jenis_pekerjaan" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Status Perkawinan</label>
                                    <select name="status_perkawinan" class="form-select">
                                        <option value="BELUM KAWIN">BELUM KAWIN</option>
                                        <option value="KAWIN">KAWIN</option>
                                        <option value="CERAI HIDUP">CERAI HIDUP</option>
                                        <option value="CERAI MATI">CERAI MATI</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Kewarganegaraan</label>
                                    <input type="text" name="kewarganegaraan" class="form-control" value="WNI">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-section">
                                    <div class="section-title">Dokumen Imigrasi</div>
                                    <label class="form-label">No. Paspor</label>
                                    <input type="text" name="no_paspor" class="form-control mb-2" value="-">
                                    <label class="form-label">No. KITAB</label>
                                    <input type="text" name="no_kitab" class="form-control" value="-">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-section">
                                    <div class="section-title">Nama Orang Tua</div>
                                    <label class="form-label">Nama Ayah</label>
                                    <input type="text" name="nama_ayah" class="form-control mb-2" required>
                                    <label class="form-label">Nama Ibu</label>
                                    <input type="text" name="nama_ibu" class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <div class="mt-3 d-flex gap-2">
                            <button type="submit" name="simpan" class="btn btn-primary flex-grow-1">Simpan Data Warga</button>
                            <a href="data_warga.php" class="btn btn-outline-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>