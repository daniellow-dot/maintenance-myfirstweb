<?php
include 'koneksi.php';

// 1. Ambil data lama berdasarkan nomor KK
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($koneksi, $_GET['id']);
    $query = mysqli_query($koneksi, "SELECT * FROM data_kk WHERE no_kk='$id'");
    $data = mysqli_fetch_assoc($query);

    if (!$data) {
        echo "<script>alert('Data tidak ditemukan!'); window.location='data_kk.php';</script>";
        exit;
    }
}

// 2. Logika Simpan Perubahan
if (isset($_POST['update'])) {
    $kepala = mysqli_real_escape_string($koneksi, $_POST['kepala_keluarga']);
    $alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);
    $kelurahan = mysqli_real_escape_string($koneksi, $_POST['kelurahan']);
    $rt = mysqli_real_escape_string($koneksi, $_POST['rt']);
    $rw = mysqli_real_escape_string($koneksi, $_POST['rw']);

    $update = mysqli_query($koneksi, "UPDATE data_kk SET 
                kepala_keluarga='$kepala', 
                alamat='$alamat', 
                kelurahan='$kelurahan',
                rt='$rt', 
                rw='$rw' 
                WHERE no_kk='$id'");

    if ($update) {
        echo "<script>alert('Data Berhasil Diperbarui!'); window.location='data_kk.php';</script>";
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
    <title>Edit Data KK - Curahgrinting</title>
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

        .form-control {
            border-radius: 10px;
            padding: 12px 15px;
            border: 1px solid #e2e8f0;
            background-color: #fcfdfe;
        }

        .form-control:focus {
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

        .info-no-kk {
            background: #f1f5f9;
            padding: 10px 15px;
            border-radius: 10px;
            font-family: monospace;
            font-size: 1.1rem;
            color: #1e3a8a;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="header-edit text-center">
    <div class="container">
        <h2 class="fw-bold">Pembaruan Data</h2>
        <p class="opacity-75">Silakan sesuaikan informasi Kartu Keluarga di bawah ini.</p>
    </div>
</div>

<div class="container mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card card-edit">
                <div class="card-header-custom">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 p-2 rounded-3 me-3">
                            <i class="bi bi-pencil-square text-primary fs-4"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold">Formulir Edit KK</h5>
                            <small class="text-muted">ID Sistem: <?= $data['no_kk']; ?></small>
                        </div>
                    </div>
                </div>
                
                <div class="card-body p-4">
                    <form method="POST">
                        <div class="mb-4">
                            <label class="form-label">Nomor Kartu Keluarga</label>
                            <div class="info-no-kk text-center">
                                <i class="bi bi-card-list me-2"></i><?= $data['no_kk']; ?>
                            </div>
                            <small class="text-muted mt-1 d-block">Nomor KK bersifat permanen dan tidak dapat diubah.</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nama Kepala Keluarga</label>
                            <input type="text" name="kepala_keluarga" class="form-control" value="<?= htmlspecialchars($data['kepala_keluarga']); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Alamat Lengkap</label>
                            <textarea name="alamat" class="form-control" rows="2" required><?= htmlspecialchars($data['alamat']); ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kelurahan / Desa</label>
                            <input type="text" name="kelurahan" class="form-control" value="<?= htmlspecialchars($data['kelurahan']); ?>" required>
                        </div>

                        <div class="row mb-4">
                            <div class="col-6">
                                <label class="form-label">RT</label>
                                <input type="text" name="rt" class="form-control" value="<?= htmlspecialchars($data['rt']); ?>" placeholder="000">
                            </div>
                            <div class="col-6">
                                <label class="form-label">RW</label>
                                <input type="text" name="rw" class="form-control" value="<?= htmlspecialchars($data['rw']); ?>" placeholder="000">
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" name="update" class="btn btn-primary btn-save">
                                <i class="bi bi-check-circle me-2"></i>Simpan Perubahan
                            </button>
                            <a href="data_kk.php" class="btn btn-link text-muted fw-semibold text-decoration-none mt-2">
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

</body>
</html>