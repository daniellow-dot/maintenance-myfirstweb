<?php
include 'koneksi.php';

// 1. Logika Pencarian
$search = isset($_GET['search']) ? mysqli_real_escape_string($koneksi, $_GET['search']) : '';
$where_clause = "";
if (!empty($search)) {
    $where_clause = "WHERE no_kk LIKE '%$search%' OR kepala_keluarga LIKE '%$search%' OR alamat LIKE '%$search%'";
}

// 2. Ambil Total Warga untuk Navbar (Sesuai index.php)
$q_total = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM data_warga");
$total_warga = mysqli_fetch_assoc($q_total)['total'] ?? 0;

// 3. Query Data KK
$query_kk = "SELECT * FROM data_kk $where_clause ORDER BY no_kk ASC";
$result_kk = mysqli_query($koneksi, $query_kk);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen KK - Curahgrinting</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root {
            --nav-bg: #1e40af;
            --nav-gradient: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
        }

        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; color: #1e293b; }
        
        /* CSS NAVIGASI PERSIS INDEX.PHP */
        .navbar { 
            background: var(--nav-gradient) !important;
            padding: 0.7rem 0;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .navbar-brand { font-size: 1.3rem; color: #ffffff !important; font-weight: 700; }
        .nav-link { 
            color: rgba(255, 255, 255, 0.75) !important; 
            font-weight: 500; 
            padding: 0.5rem 1.2rem !important;
            transition: all 0.3s ease;
        }
        .nav-link:hover { 
            color: #ffffff !important; 
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
        }
        .nav-link.active { 
            color: #ffffff !important; 
            font-weight: 700;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 8px;
        }
        .btn-input {
            background-color: #ffffff;
            color: #1e40af !important;
            border: none;
            border-radius: 8px;
            padding: 8px 18px;
            font-weight: 700;
            font-size: 0.85rem;
        }

        /* Card & Table Styling */
        .main-card { background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); overflow: hidden; }
        .table thead th { 
            background: #f8fafc; border-bottom: 2px solid #edf2f7; 
            color: #64748b; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.025em;
            padding: 15px;
        }
        .table tbody td { padding: 15px; vertical-align: middle; border-bottom: 1px solid #f1f5f9; }
        
        .btn-action { 
            width: 35px; height: 35px; display: inline-flex; align-items: center; justify-content: center; 
            border-radius: 10px; transition: 0.3s; border: none; text-decoration: none;
        }
        .btn-detail { background: #eef2ff; color: #4338ca; }
        .btn-edit { background: #fffbeb; color: #d97706; }
        .btn-delete { background: #fef2f2; color: #dc2626; }
        
    </style>
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container py-5">
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h3 class="fw-bold mb-0">Database Kartu Keluarga</h3>
            <p class="text-muted small">Terdapat <strong><?= $total_warga; ?></strong> jiwa terdaftar saat ini.</p>
        </div>
        <div class="col-md-6">
            <form action="" method="GET" class="input-group shadow-sm">
                <input type="text" name="search" class="form-control search-input" placeholder="Cari No. KK atau Nama Kepala..." value="<?= htmlspecialchars($search); ?>">
                <button class="btn btn-primary search-btn" type="submit">
                    <i class="bi bi-search"></i>
                </button>
            </form>
        </div>
    </div>

    <div class="main-card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th>Nomor KK</th>
                        <th>Kepala Keluarga</th>
                        <th>Alamat</th>
                        <th class="text-center">RT/RW</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1;
                    if (mysqli_num_rows($result_kk) > 0) :
                        while($kk = mysqli_fetch_assoc($result_kk)) : 
                    ?>
                    <tr>
                        <td class="text-center text-muted"><?= $no++; ?></td>
                        <td><code class="fw-bold text-dark fs-6"><?= $kk['no_kk']; ?></code></td>
                        <td>
                            <div class="fw-bold text-uppercase"><?= $kk['kepala_keluarga']; ?></div>
                            <span class="text-muted" style="font-size: 0.7rem;">Kab. Probolinggo</span>
                        </td>
                        <td class="small text-muted">
                            <?= $kk['alamat']; ?>, <br>
                            <span class="text-dark"><?= $kk['kelurahan']; ?></span>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-light text-dark border px-2 py-1"><?= $kk['rt']; ?> / <?= $kk['rw']; ?></span>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="detail_kk.php?no_kk=<?= $kk['no_kk']; ?>" class="btn-action btn-detail" title="Lihat Anggota Keluarga">
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                                <a href="edit_kk.php?id=<?= $kk['no_kk']; ?>" class="btn-action btn-edit" title="Edit Data KK">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <a href="hapus_kk.php?id=<?= $kk['no_kk']; ?>" class="btn-action btn-delete" onclick="return confirm('Menghapus KK akan menghapus data yang terkait. Lanjutkan?')" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; else : ?>
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <i class="bi bi-folder-x display-4 text-muted opacity-25"></i>
                            <p class="mt-2 text-muted italic">Data tidak ditemukan.</p>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>