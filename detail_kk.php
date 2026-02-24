<?php
include 'koneksi.php';

$no_kk = $_GET['no_kk'];

// Query data KK
$query_kk = mysqli_query($koneksi, "SELECT * FROM data_kk WHERE no_kk = '$no_kk'");
$data_kk = mysqli_fetch_assoc($query_kk);

// Query anggota keluarga
$query_warga = mysqli_query($koneksi, "SELECT * FROM data_warga WHERE no_kk = '$no_kk' 
               ORDER BY CASE 
                 WHEN status_hubungan = 'KEPALA KELUARGA' THEN 1 
                 WHEN status_hubungan = 'ISTRI' THEN 2 
                 ELSE 3 END ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Keluarga - <?= $no_kk; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { background-color: #f4f6f9; font-size: 0.85rem; }
        .kk-paper { 
            background: white; 
            padding: 40px; 
            border-radius: 8px; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.1); 
            margin-top: 30px;
        }
        .header-line { border-bottom: 3px solid #000; margin-bottom: 20px; padding-bottom: 10px; }
        .table-kk td, .table-kk th { border: 1px solid #000 !important; padding: 8px; }
        @media print { .no-print { display: none; } .kk-paper { box-shadow: none; margin: 0; } }
    </style>
</head>
<body>

<div class="container py-4">
    <div class="d-flex justify-content-between no-print mb-4">
        <a href="data_kk.php" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
        <button onclick="window.print()" class="btn btn-primary"><i class="bi bi-printer"></i> Cetak Dokumen</button>
    </div>

    <div class="kk-paper mx-auto">
        <div class="header-line text-center">
            <h3 class="fw-bold mb-1">KARTU KELUARGA</h3>
            <h5 class="mb-0">No. <?= $data_kk['no_kk']; ?></h5>
        </div>

        <div class="row mb-4">
            <div class="col-6">
                <table class="table table-sm table-borderless">
                    <tr><td width="150">Nama Kepala Keluarga</td><td>: <?= strtoupper($data_kk['kepala_keluarga']); ?></td></tr>
                    <tr><td>Alamat</td><td>: <?= strtoupper($data_kk['alamat']); ?></td></tr>
                    <tr><td>RT/RW</td><td>: <?= $data_kk['rt']; ?> / <?= $data_kk['rw']; ?></td></tr>
                    <tr><td>Desa/Kelurahan</td><td>: <?= strtoupper($data_kk['kelurahan']); ?></td></tr>
                </table>
            </div>
            <div class="col-6">
                <table class="table table-sm table-borderless">
                    <tr><td width="150">Kecamatan</td><td>: <?= strtoupper($data_kk['kecamatan']); ?></td></tr>
                    <tr><td>Kota</td><td>: <?= strtoupper($data_kk['kota']); ?></td></tr>
                    <tr><td>Kode Pos</td><td>: <?= $data_kk['kode_pos']; ?></td></tr>
                    <tr><td>Provinsi</td><td>: <?= strtoupper($data_kk['provinsi']); ?></td></tr>
                </table>
            </div>
        </div>

        <table class="table table-kk">
            <thead class="bg-light text-center">
                <tr>
                    <th>No</th>
                    <th>Nama Lengkap</th>
                    <th>NIK</th>
                    <th>L/P</th>
                    <th>Tempat Lahir</th>
                    <th>Tgl Lahir</th>
                    <th>Pendidikan</th>
                    <th>Pekerjaan</th>
                    <th>Hubungan</th>
                </tr>
            </thead>
            <tbody>
                <?php $n=1; while($w = mysqli_fetch_assoc($query_warga)): ?>
                <tr>
                    <td class="text-center"><?= $n++; ?></td>
                    <td class="fw-bold"><?= strtoupper($w['nama_lengkap']); ?></td>
                    <td><?= $w['nik']; ?></td>
                    <td class="text-center"><?= $w['jenis_kelamin'] == 'Laki-laki' ? 'L' : 'P'; ?></td>
                    <td><?= strtoupper($w['tempat_lahir']); ?></td>
                    <td><?= date('d-m-Y', strtotime($w['tgl_lahir'])); ?></td>
                    <td><?= strtoupper($w['pendidikan']); ?></td>
                    <td><?= strtoupper($w['jenis_pekerjaan']); ?></td>
                    <td class="text-center small"><?= $w['status_hubungan']; ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>