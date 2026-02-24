<?php
include 'koneksi.php';
// session_start(); // Aktifkan jika belum ada di koneksi.php

// --- LOGIKA FILTER & PENCARIAN ---
// Ambil filter dari URL (agar sinkron dengan navbar.php)
$search = isset($_GET['search']) ? mysqli_real_escape_string($koneksi, $_GET['search']) : '';
$f_rt   = isset($_GET['rt']) ? mysqli_real_escape_string($koneksi, $_GET['rt']) : '';
$f_rw   = isset($_GET['rw']) ? mysqli_real_escape_string($koneksi, $_GET['rw']) : '';

// 1. Membangun WHERE clause secara dinamis
$where_clause = " WHERE 1=1 ";
if($search != '') {
    $where_clause .= " AND (w.nama_lengkap LIKE '%$search%' OR w.nik LIKE '%$search%' OR k.no_kk LIKE '%$search%')";
}
if($f_rt != '') {
    $where_clause .= " AND k.rt = '$f_rt'";
}
if($f_rw != '') {
    $where_clause .= " AND k.rw = '$f_rw'";
}

// 2. Ambil Total Warga (Terfilter)
$q_total = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM data_warga w JOIN data_kk k ON w.no_kk = k.no_kk $where_clause");
$total_warga = mysqli_fetch_assoc($q_total)['total'] ?? 0;

// 3. Query Utama (Filter + Search + Urutan Keluarga)
$query = "SELECT w.*, k.*, w.id_warga as id_warga_asli FROM data_warga w
          JOIN data_kk k ON w.no_kk = k.no_kk 
          $where_clause
          ORDER BY k.no_kk ASC, 
          CASE 
            WHEN UPPER(w.status_hubungan) = 'KEPALA KELUARGA' THEN 1 
            WHEN UPPER(w.status_hubungan) = 'ISTRI' THEN 2 
            WHEN UPPER(w.status_hubungan) = 'ANAK' THEN 3 
            ELSE 4 
          END ASC, w.tgl_lahir ASC";

$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Kartu Keluarga - Curahgrinting</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        :root { --primary-blue: #1e40af; --soft-bg: #f8fafc; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: var(--soft-bg); color: #1e293b; }
        
        .page-header {
            background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
            color: white; padding: 40px 0 80px 0; margin-bottom: -60px;
        }

        .kk-card {
            background: #ffffff; padding: 40px; margin-bottom: 50px; border-radius: 20px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1); border: 1px solid #e2e8f0; position: relative;
        }
        .kk-card::before { content: ""; position: absolute; top: 0; left: 0; width: 100%; height: 8px; background: var(--primary-blue); border-radius: 20px 20px 0 0; }

        .kk-header-title { text-align: center; font-weight: 800; font-size: 1.6rem; color: #0f172a; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 5px; }
        .info-grid { background: #f8fafc; border: 1px solid #f1f5f9; border-radius: 12px; padding: 20px; margin: 25px 0; }
        .label-text { font-weight: 600; color: #64748b; width: 200px; font-size: 0.85rem; }
        .value-text { font-weight: 700; color: #1e293b; text-transform: uppercase; font-size: 0.85rem; }

        .table-kk thead th { background: #f1f5f9; font-size: 0.7rem; text-transform: uppercase; font-weight: 700; border: 1px solid #cbd5e1; padding: 12px 5px; }
        .table-kk tbody td { font-size: 0.75rem; border: 1px solid #cbd5e1; padding: 10px 5px; }

        .badge-status { padding: 5px 10px; border-radius: 6px; font-size: 0.65rem; font-weight: 700; text-transform: uppercase; }
        .bg-kepala { background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe; }
        .bg-istri { background: #fdf2f8; color: #9d174d; border: 1px solid #fbcfe8; }
        .bg-anak { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }

        .btn-print-float { position: fixed; bottom: 30px; right: 30px; z-index: 1000; border-radius: 50px; padding: 15px 25px; box-shadow: 0 10px 15px rgba(0,0,0,0.2); }

        .btn-action { padding: 4px 8px; font-size: 0.8rem; border-radius: 8px; }

        @media print {
            .no-print, nav, .btn-print-float, .search-section, .col-aksi, .cell-aksi, .filter-bar { display: none !important; }
            body { background: white; padding: 0; }
            .kk-card { box-shadow: none; border: 1px solid #000; margin: 0; padding: 20px; page-break-after: always; }
        }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="page-header text-center no-print">
    <div class="container">
        <h2 class="fw-bold">Database Kependudukan</h2>
        <p class="opacity-75">
            <?php if($f_rt != '' || $f_rw != ''): ?>
                Filter Wilayah: RW <?= $f_rw ?: '-' ?> / RT <?= $f_rt ?: '-' ?> | 
            <?php endif; ?>
            Hasil: <strong><?= $total_warga ?></strong> Jiwa
        </p>
    </div>
</div>

<button onclick="window.print()" class="btn btn-dark btn-print-float no-print">
    <i class="bi bi-printer-fill me-2"></i> Cetak Halaman Ini
</button>

<div class="container-fluid py-5">
    
    <div class="row justify-content-center mb-5 no-print search-section">
        <div class="col-md-6">
            <form method="GET" action="">
                <input type="hidden" name="rt" value="<?= htmlspecialchars($f_rt) ?>">
                <input type="hidden" name="rw" value="<?= htmlspecialchars($f_rw) ?>">
                
                <div class="input-group input-group-lg shadow-sm" style="border-radius: 15px; overflow: hidden;">
                    <span class="input-group-text bg-white border-end-0 text-primary">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" name="search" class="form-control border-start-0 ps-0" 
                           placeholder="Cari Nama, NIK, atau No. KK..." 
                           value="<?= htmlspecialchars($search) ?>">
                    <button class="btn btn-primary px-4 fw-bold" type="submit">Cari</button>
                </div>
                <?php if($search != ''): ?>
                    <div class="text-center mt-2">
                        <a href="data_warga.php?rt=<?= $f_rt ?>&rw=<?= $f_rw ?>" class="text-danger small text-decoration-none">
                            <i class="bi bi-x-circle"></i> Bersihkan Kata Kunci
                        </a>
                    </div>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <?php 
    $current_kk = null;
    if (mysqli_num_rows($result) > 0) :
        while($row = mysqli_fetch_assoc($result)) : 
            
            // Logika grouping per Kartu Keluarga
            if ($current_kk !== $row['no_kk']) :
                if ($current_kk !== null) echo '</tbody></table></div></div>';
                
                $current_kk = $row['no_kk'];
                $no_urut = 1; 
    ?>
        <div class="kk-card mx-auto" style="max-width: 1240px;">
            <div class="kk-header-title">Kartu Keluarga</div>
            <div class="text-center fw-bold fs-5 mb-3">No. <?= $row['no_kk']; ?></div>

            <div class="info-grid">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-sm table-borderless mb-0">
                            <tr><td class="label-text">Kepala Keluarga</td><td class="value-text">: <?= $row['kepala_keluarga']; ?></td></tr>
                            <tr><td class="label-text">Alamat</td><td class="value-text">: <?= $row['alamat']; ?></td></tr>
                            <tr><td class="label-text">RT/RW</td><td class="value-text">: <?= $row['rt']; ?> / <?= $row['rw']; ?></td></tr>
                            <tr><td class="label-text">Desa/Kelurahan</td><td class="value-text">: <?= $row['kelurahan']; ?></td></tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-sm table-borderless mb-0">
                            <tr><td class="label-text">Kecamatan</td><td class="value-text">: <?= $row['kecamatan']; ?></td></tr>
                            <tr><td class="label-text">Kabupaten/Kota</td><td class="value-text">: <?= $row['kabupaten']; ?></td></tr>
                            <tr><td class="label-text">Kode Pos</td><td class="value-text">: <?= $row['kode_pos']; ?></td></tr>
                            <tr><td class="label-text">Provinsi</td><td class="value-text">: <?= $row['provinsi']; ?></td></tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-kk align-middle text-center table-bordered">
                    <thead>
                        <tr>
                            <th rowspan="2">No</th>
                            <th rowspan="2" style="min-width: 150px;">Nama Lengkap</th>
                            <th rowspan="2">NIK</th>
                            <th rowspan="2">JK</th>
                            <th rowspan="2">Tempat, Tgl Lahir</th>
                            <th rowspan="2">Agama</th>
                            <th rowspan="2">Pendidikan</th>
                            <th rowspan="2">Pekerjaan</th>
                            <th colspan="2">Status</th>
                            <th rowspan="2">Kewarganegaraan</th>
                            <th rowspan="2" class="no-print col-aksi">Aksi</th>
                        </tr>
                        <tr>
                            <th>Perkawinan</th>
                            <th>Keluarga</th>
                        </tr>
                    </thead>
                    <tbody>
    <?php endif; ?>
        
        <tr>
            <td><?= $no_urut++; ?></td>
            <td class="text-start fw-bold text-uppercase"><?= $row['nama_lengkap']; ?></td>
            <td class="font-monospace"><?= $row['nik']; ?></td>
            <td><?= ($row['jenis_kelamin'] == 'Laki-laki' || $row['jenis_kelamin'] == 'L') ? 'L' : 'P'; ?></td>
            <td class="text-uppercase small"><?= $row['tempat_lahir']; ?>, <?= date('d-m-Y', strtotime($row['tgl_lahir'])); ?></td>
            <td class="small"><?= $row['agama']; ?></td>
            <td class="small"><?= $row['pendidikan']; ?></td>
            <td class="small"><?= $row['jenis_pekerjaan']; ?></td>
            <td>
                <span class="badge-status <?= $row['status_perkawinan'] == 'KAWIN' ? 'bg-anak' : 'bg-istri'; ?>">
                    <?= $row['status_perkawinan']; ?>
                </span>
            </td>
            <td>
                <?php
                    $st = strtoupper($row['status_hubungan']);
                    $cls = ($st == 'KEPALA KELUARGA') ? 'bg-kepala' : (($st == 'ISTRI') ? 'bg-istri' : 'bg-anak');
                ?>
                <span class="badge-status <?= $cls; ?>"><?= $st; ?></span>
            </td>
            <td class="small"><?= $row['kewarganegaraan']; ?></td>
            <td class="no-print cell-aksi">
                <div class="d-flex gap-1 justify-content-center">
                    <a href="edit_warga.php?id=<?= $row['id_warga']; ?>" class="btn btn-warning btn-action text-white">
    					<i class="bi bi-pencil-square"></i>
					</a>
					<a href="hapus_warga.php?id=<?= $row['id_warga']; ?>" class="btn btn-danger btn-action" 
   						onclick="return confirm('Hapus data <?= $row['nama_lengkap']; ?>?')">
    					<i class="bi bi-trash"></i>
				</a>
                </div>
            </td>
        </tr>

    <?php 
        endwhile; 
        echo '</tbody></table></div></div>';
    else : ?>
        <div class="text-center py-5">
            <i class="bi bi-search display-1 text-muted"></i>
            <h4 class="mt-3 text-muted">Data warga tidak ditemukan</h4>
            <p>Cobalah kata kunci lain atau periksa filter RT/RW anda di navbar.</p>
        </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>