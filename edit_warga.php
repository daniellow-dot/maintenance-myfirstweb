<?php
include 'koneksi.php';

// 1. Ambil data lama berdasarkan id_warga
if (isset($_GET['id'])) {
    $id_warga = mysqli_real_escape_string($koneksi, $_GET['id']);
    $query = mysqli_query($koneksi, "SELECT * FROM data_warga WHERE id_warga='$id_warga'");
    $data = mysqli_fetch_assoc($query);

    if (!$data) {
        echo "<script>alert('Data warga tidak ditemukan!'); window.location='data_warga.php';</script>";
        exit;
    }
}

// 2. Logika Simpan Perubahan
if (isset($_POST['update'])) {
    $nama_lengkap      = strtoupper(mysqli_real_escape_string($koneksi, $_POST['nama_lengkap']));
    $nik               = mysqli_real_escape_string($koneksi, $_POST['nik']);
    $jenis_kelamin     = mysqli_real_escape_string($koneksi, $_POST['jenis_kelamin']);
    $tempat_lahir      = mysqli_real_escape_string($koneksi, $_POST['tempat_lahir']);
    $tgl_lahir         = mysqli_real_escape_string($koneksi, $_POST['tgl_lahir']);
    $agama             = mysqli_real_escape_string($koneksi, $_POST['agama']);
    $pendidikan        = mysqli_real_escape_string($koneksi, $_POST['pendidikan']);
    $jenis_pekerjaan   = mysqli_real_escape_string($koneksi, $_POST['jenis_pekerjaan']);
    $status_perkawinan = mysqli_real_escape_string($koneksi, $_POST['status_perkawinan']);
    $status_hubungan   = mysqli_real_escape_string($koneksi, $_POST['status_hubungan']);
    $kewarganegaraan   = mysqli_real_escape_string($koneksi, $_POST['kewarganegaraan']);
    $no_paspor         = mysqli_real_escape_string($koneksi, $_POST['no_paspor']);
    $no_kitab          = mysqli_real_escape_string($koneksi, $_POST['no_kitab']);
    $nama_ayah         = strtoupper(mysqli_real_escape_string($koneksi, $_POST['nama_ayah']));
    $nama_ibu          = strtoupper(mysqli_real_escape_string($koneksi, $_POST['nama_ibu']));

    $update = mysqli_query($koneksi, "UPDATE data_warga SET 
                nama_lengkap='$nama_lengkap',
                nik='$nik',
                jenis_kelamin='$jenis_kelamin',
                tempat_lahir='$tempat_lahir',
                tgl_lahir='$tgl_lahir',
                agama='$agama',
                pendidikan='$pendidikan',
                jenis_pekerjaan='$jenis_pekerjaan',
                status_perkawinan='$status_perkawinan',
                status_hubungan='$status_hubungan',
                kewarganegaraan='$kewarganegaraan',
                no_paspor='$no_paspor',
                no_kitab='$no_kitab',
                nama_ayah='$nama_ayah',
                nama_ibu='$nama_ibu'
                WHERE id_warga='$id_warga'");

    if ($update) {
        echo "<script>alert('Data Warga Berhasil Diperbarui!'); window.location='data_warga.php';</script>";
    } else {
        $error = mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Warga - Curahgrinting</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        :root {
            --nav-gradient: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
        }

        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #f8fafc; 
            color: #1e293b; 
        }

        .header-edit {
            background: var(--nav-gradient);
            color: white;
            padding: 40px 0 100px 0;
            margin-bottom: -60px;
        }

        .card-edit {
            background: #ffffff;
            border-radius: 20px;
            border: none;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
            overflow: hidden;
        }

        .card-header-custom {
            background: #ffffff;
            padding: 25px 30px;
            border-bottom: 1px solid #f1f5f9;
        }

        .form-label {
            font-weight: 600;
            font-size: 0.85rem;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.025em;
        }

        .form-control, .form-select {
            border-radius: 10px;
            padding: 12px 15px;
            border: 1px solid #e2e8f0;
            background-color: #fcfdfe;
        }

        .form-control:focus, .form-select:focus {
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
            border-color: #2563eb;
        }

        .btn-save {
            background: var(--nav-gradient);
            border: none;
            border-radius: 12px;
            padding: 12px;
            font-weight: 700;
            transition: 0.3s;
        }

        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(37, 99, 235, 0.4);
        }

        .info-nik {
            background: #f1f5f9;
            padding: 10px 15px;
            border-radius: 10px;
            font-family: monospace;
            font-size: 1.1rem;
            color: #1e3a8a;
            font-weight: bold;
        }

        .section-title {
            font-weight: 700;
            color: #1e293b;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 10px;
            margin-top: 25px;
            margin-bottom: 15px;
            font-size: 0.95rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .alert {
            border-radius: 10px;
            border: none;
        }
    </style>
</head>
<body>

<div class="header-edit text-center">
    <div class="container">
        <h2 class="fw-bold">Edit Data Warga</h2>
        <p class="opacity-75">Perbarui informasi data warga sesuai kebutuhan.</p>
    </div>
</div>

<div class="container mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card card-edit">
                <div class="card-header-custom">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 p-2 rounded-3 me-3">
                            <i class="bi bi-pencil-square text-primary fs-4"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold">Formulir Edit Data Warga</h5>
                            <small class="text-muted">ID: <?= htmlspecialchars($data['id_warga']); ?> | NIK: <?= htmlspecialchars($data['nik']); ?></small>
                        </div>
                    </div>
                </div>
                
                <div class="card-body p-4">
                    <?php if(isset($error)): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            <strong>Error:</strong> <?= htmlspecialchars($error); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form method="POST">
                        <!-- IDENTITAS PRIBADI -->
                        <div class="section-title">
                            <i class="bi bi-person-badge me-2"></i>Identitas Pribadi
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" class="form-control" 
                                   value="<?= htmlspecialchars($data['nama_lengkap']); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nomor Induk Kependudukan (NIK)</label>
                            <div class="info-nik text-center">
                                <i class="bi bi-card-list me-2"></i><?= htmlspecialchars($data['nik']); ?>
                            </div>
                            <small class="text-muted mt-1 d-block">NIK bersifat permanen dan tidak dapat diubah.</small>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Jenis Kelamin</label>
                                <select name="jenis_kelamin" class="form-select" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="L" <?= ($data['jenis_kelamin'] == 'L') ? 'selected' : ''; ?>>Laki-laki</option>
                                    <option value="P" <?= ($data['jenis_kelamin'] == 'P') ? 'selected' : ''; ?>>Perempuan</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Agama</label>
                                <select name="agama" class="form-select" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="Islam" <?= ($data['agama'] == 'Islam') ? 'selected' : ''; ?>>Islam</option>
                                    <option value="Kristen" <?= ($data['agama'] == 'Kristen') ? 'selected' : ''; ?>>Kristen</option>
                                    <option value="Katolik" <?= ($data['agama'] == 'Katolik') ? 'selected' : ''; ?>>Katolik</option>
                                    <option value="Hindu" <?= ($data['agama'] == 'Hindu') ? 'selected' : ''; ?>>Hindu</option>
                                    <option value="Budha" <?= ($data['agama'] == 'Budha') ? 'selected' : ''; ?>>Budha</option>
                                    <option value="Konghucu" <?= ($data['agama'] == 'Konghucu') ? 'selected' : ''; ?>>Konghucu</option>
                                </select>
                            </div>
                        </div>

                        <!-- TEMPAT & TANGGAL LAHIR -->
                        <div class="section-title">
                            <i class="bi bi-calendar-event me-2"></i>Tempat & Tanggal Lahir
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" class="form-control" 
                                       value="<?= htmlspecialchars($data['tempat_lahir']); ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tanggal Lahir</label>
                                <input type="date" name="tgl_lahir" class="form-control" 
                                       value="<?= htmlspecialchars($data['tgl_lahir']); ?>" required>
                            </div>
                        </div>

                        <!-- PENDIDIKAN & PEKERJAAN -->
                        <div class="section-title">
                            <i class="bi bi-briefcase me-2"></i>Pendidikan & Pekerjaan
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Pendidikan</label>
                                <select name="pendidikan" class="form-select" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="TK" <?= ($data['pendidikan'] == 'TK') ? 'selected' : ''; ?>>TK</option>
                                    <option value="SD" <?= ($data['pendidikan'] == 'SD') ? 'selected' : ''; ?>>SD</option>
                                    <option value="SMP" <?= ($data['pendidikan'] == 'SMP') ? 'selected' : ''; ?>>SMP</option>
                                    <option value="SMA" <?= ($data['pendidikan'] == 'SMA') ? 'selected' : ''; ?>>SMA</option>
                                    <option value="D1" <?= ($data['pendidikan'] == 'D1') ? 'selected' : ''; ?>>D1</option>
                                    <option value="D2" <?= ($data['pendidikan'] == 'D2') ? 'selected' : ''; ?>>D2</option>
                                    <option value="D3" <?= ($data['pendidikan'] == 'D3') ? 'selected' : ''; ?>>D3</option>
                                    <option value="S1" <?= ($data['pendidikan'] == 'S1') ? 'selected' : ''; ?>>S1</option>
                                    <option value="S2" <?= ($data['pendidikan'] == 'S2') ? 'selected' : ''; ?>>S2</option>
                                    <option value="S3" <?= ($data['pendidikan'] == 'S3') ? 'selected' : ''; ?>>S3</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Jenis Pekerjaan</label>
                                <input type="text" name="jenis_pekerjaan" class="form-control" 
                                       value="<?= htmlspecialchars($data['jenis_pekerjaan']); ?>" required>
                            </div>
                        </div>

                        <!-- STATUS KELUARGA -->
                        <div class="section-title">
                            <i class="bi bi-people-fill me-2"></i>Status Keluarga
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Status Perkawinan</label>
                                <select name="status_perkawinan" class="form-select" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="BELUM KAWIN" <?= ($data['status_perkawinan'] == 'BELUM KAWIN') ? 'selected' : ''; ?>>Belum Kawin</option>
                                    <option value="KAWIN" <?= ($data['status_perkawinan'] == 'KAWIN') ? 'selected' : ''; ?>>Kawin</option>
                                    <option value="CERAI HIDUP" <?= ($data['status_perkawinan'] == 'CERAI HIDUP') ? 'selected' : ''; ?>>Cerai Hidup</option>
                                    <option value="CERAI MATI" <?= ($data['status_perkawinan'] == 'CERAI MATI') ? 'selected' : ''; ?>>Cerai Mati</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Status Hubungan dalam Keluarga</label>
                                <select name="status_hubungan" class="form-select" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="KEPALA KELUARGA" <?= ($data['status_hubungan'] == 'KEPALA KELUARGA') ? 'selected' : ''; ?>>Kepala Keluarga</option>
                                    <option value="ISTRI" <?= ($data['status_hubungan'] == 'ISTRI') ? 'selected' : ''; ?>>Istri</option>
                                    <option value="ANAK" <?= ($data['status_hubungan'] == 'ANAK') ? 'selected' : ''; ?>>Anak</option>
                                    <option value="MENANTU" <?= ($data['status_hubungan'] == 'MENANTU') ? 'selected' : ''; ?>>Menantu</option>
                                    <option value="CUCU" <?= ($data['status_hubungan'] == 'CUCU') ? 'selected' : ''; ?>>Cucu</option>
                                    <option value="ORANG TUA" <?= ($data['status_hubungan'] == 'ORANG TUA') ? 'selected' : ''; ?>>Orang Tua</option>
                                    <option value="MERTUA" <?= ($data['status_hubungan'] == 'MERTUA') ? 'selected' : ''; ?>>Mertua</option>
                                    <option value="PEMBANTU" <?= ($data['status_hubungan'] == 'PEMBANTU') ? 'selected' : ''; ?>>Pembantu</option>
                                    <option value="LAINNYA" <?= ($data['status_hubungan'] == 'LAINNYA') ? 'selected' : ''; ?>>Lainnya</option>
                                </select>
                            </div>
                        </div>

                        <!-- DATA ORANG TUA -->
                        <div class="section-title">
                            <i class="bi bi-heart-fill me-2"></i>Data Orang Tua
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Nama Ayah</label>
                                <input type="text" name="nama_ayah" class="form-control" 
                                       value="<?= htmlspecialchars($data['nama_ayah']); ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nama Ibu</label>
                                <input type="text" name="nama_ibu" class="form-control" 
                                       value="<?= htmlspecialchars($data['nama_ibu']); ?>">
                            </div>
                        </div>

                        <!-- DOKUMEN -->
                        <div class="section-title">
                            <i class="bi bi-file-earmark me-2"></i>Dokumen Identitas
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Nomor Paspor</label>
                                <input type="text" name="no_paspor" class="form-control" 
                                       value="<?= htmlspecialchars($data['no_paspor']); ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nomor KITAB</label>
                                <input type="text" name="no_kitab" class="form-control" 
                                       value="<?= htmlspecialchars($data['no_kitab']); ?>">
                            </div>
                        </div>

                        <!-- KEWARGANEGARAAN -->
                        <div class="mb-4">
                            <label class="form-label">Kewarganegaraan</label>
                            <select name="kewarganegaraan" class="form-select" required>
                                <option value="">-- Pilih --</option>
                                <option value="WNI" <?= ($data['kewarganegaraan'] == 'WNI') ? 'selected' : ''; ?>>WNI (Warga Negara Indonesia)</option>
                                <option value="WNA" <?= ($data['kewarganegaraan'] == 'WNA') ? 'selected' : ''; ?>>WNA (Warga Negara Asing)</option>
                                <option value="DWIKEWARGANEGARAAN" <?= ($data['kewarganegaraan'] == 'DWIKEWARGANEGARAAN') ? 'selected' : ''; ?>>Dwikewarganegaraan</option>
                            </select>
                        </div>

                        <!-- TOMBOL AKSI -->
                        <div class="d-grid gap-2">
                            <button type="submit" name="update" class="btn btn-primary btn-save">
                                <i class="bi bi-check-circle me-2"></i>Simpan Perubahan
                            </button>
                            <a href="data_warga.php" class="btn btn-link text-muted fw-semibold text-decoration-none mt-2">
                                <i class="bi bi-arrow-left me-2"></i>Kembali ke Database
                            </a>
                        </div>
                    </form>
                </div>
            </div>
            
            <p class="text-center text-muted small mt-4">
                &copy; 2026 Desa Curahgrinting - Sistem Administrasi Kependudukan
            </p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>