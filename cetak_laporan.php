<?php
session_start();
include 'koneksi.php';

// Pastikan user sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$rt_user = $_SESSION['rt'];
$rw_user = $_SESSION['rw'];

// Ambil statistik otomatis sesuai poin A.3 dan A.4
$q_stats = mysqli_query($koneksi, "SELECT 
    COUNT(DISTINCT k.no_kk) as total_kk,
    SUM(CASE WHEN w.jenis_kelamin = 'Laki-laki' THEN 1 ELSE 0 END) as jml_l,
    SUM(CASE WHEN w.jenis_kelamin = 'Perempuan' THEN 1 ELSE 0 END) as jml_p
    FROM data_kk k 
    JOIN data_warga w ON k.no_kk = w.no_kk 
    WHERE k.rt = '$rt_user' AND k.rw = '$rw_user'");
$stats = mysqli_fetch_assoc($q_stats);

// Konfigurasi Header untuk memaksa download atau print
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak_Laporan_RT_<?= $rt_user ?>_<?= date('M_Y') ?></title>
    <style>
        @page {
            size: A4;
            margin: 0;
        }
        body {
            font-family: 'Times New Roman', Times, serif;
            margin: 0;
            padding: 0;
            background-color: #ffffff;
        }
        .paper {
            width: 210mm;
            padding: 20mm;
            margin: auto;
            box-sizing: border-box;
            page-break-after: always;
        }
        .text-header {
            text-align: center;
            font-weight: bold;
            font-size: 14pt;
            text-transform: uppercase;
            line-height: 1.2;
            margin-bottom: 20px;
        }
        .section-title {
            font-weight: bold;
            text-decoration: underline;
            text-transform: uppercase;
            margin-top: 15px;
            font-size: 12pt;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table, th, td {
            border: 1px solid black !important;
        }
        th, td {
            padding: 6px;
            font-size: 11pt;
            vertical-align: middle;
        }
        th { background-color: #f2f2f2 !important; }
        .text-center { text-align: center; }
        .text-start { text-align: left; }
        
        /* Hilangkan tombol saat cetak */
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body onload="window.print()">

<div class="no-print" style="padding: 20px; text-align: center; background: #eee;">
    <p>Pratinjau Cetak. Jika dialog print tidak muncul otomatis, klik tombol di bawah:</p>
    <button onclick="window.print()">Cetak / Simpan PDF</button>
    <a href="index.php">Kembali ke Dashboard</a>
</div>

<div class="paper">
    <div class="text-header">
        LAPORAN PELAYANAN / KEGIATAN KETUA RT / KETUA RW<br>
        Pemerintah Kota Probolinggo
    </div>

    <div style="text-align: center; margin-bottom: 20px; font-weight: bold;">
        Kelurahan : Curahgrinting &nbsp;&nbsp; Kecamatan : Kanigaran<br>
        Periode Laporan : <?= date('F Y'); ?>
    </div>

    <div class="section-title">A. DATA UMUM</div>
    <table>
        <tr><th width="5%">No</th><th width="40%">Uraian</th><th>Keterangan</th></tr>
        <tr><td class="text-center">1</td><td>Nama</td><td><?= $_SESSION['username']; ?></td></tr>
        <tr><td class="text-center">2</td><td>Jabatan</td><td>Ketua RT <?= $rt_user ?> / RW <?= $rw_user ?></td></tr>
        <tr><td class="text-center">3</td><td>Jumlah Kepala Keluarga</td><td><?= $stats['total_kk']; ?> KK</td></tr>
        <tr><td class="text-center">4</td><td>Jumlah Penduduk</td><td>L: <?= $stats['jml_l']; ?> / P: <?= $stats['jml_p']; ?> / Total: <?= $stats['jml_l'] + $stats['jml_p']; ?> Jiwa</td></tr>
        <tr><td class="text-center" rowspan="2">5</td><td>Jumlah Rumah</td><td>......... Unit</td></tr>
        <tr><td>Jumlah Tempat Ibadah</td><td>......... Unit</td></tr>
    </table>

    <div class="section-title">B. KEGIATAN PENYELENGGARAAN TUGAS (BAGIAN 1)</div>
    <table>
        <thead>
            <tr class="text-center">
                <th>No</th><th>Bidang</th><th>Uraian</th><th>Jml</th><th>Satuan</th><th>Hasil</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td><td>Kependudukan</td><td>Pendataan warga baru</td><td></td><td>Orang</td><td>Update</td>
            </tr>
            <tr>
                <td>2</td><td>Keamanan</td><td>Ronda Malam</td><td></td><td>Kali</td><td>Aman</td>
            </tr>
            </tbody>
    </table>
</div>

<div class="paper">
    <div class="section-title">C. REKAPITULASI PERMASALAHAN</div>
    <table>
        <tr><th width="5%">No</th><th>Jenis Masalah</th><th>Upaya Penyelesaian</th><th>Status</th></tr>
        <tr><td class="text-center">1</td><td>Sosial</td><td></td><td></td></tr>
        <tr><td class="text-center">2</td><td>Lingkungan</td><td></td><td></td></tr>
    </table>

    <div style="margin-top: 50px; display: flex; justify-content: space-between; text-align: center;">
        <div style="width: 200px;">
            Mengetahui,<br>Lurah Curahgrinting<br><br><br><br>
            ( <strong>Rois Hidayat S.Pd Mpd</strong> )
        </div>
        <div style="width: 200px;">
            Probolinggo, <?= date('d M Y'); ?><br>Ketua RT <?= $rt_user ?><br><br><br><br>
            ( <strong><?= $_SESSION['username']; ?></strong> )
        </div>
    </div>
</div>

</body>
</html>