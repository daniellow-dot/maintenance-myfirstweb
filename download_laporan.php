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

// Ambil statistik otomatis dari database
$q_stats = mysqli_query($koneksi, "SELECT 
    COUNT(DISTINCT k.no_kk) as total_kk,
    SUM(CASE WHEN w.jenis_kelamin = 'Laki-laki' THEN 1 ELSE 0 END) as jml_l,
    SUM(CASE WHEN w.jenis_kelamin = 'Perempuan' THEN 1 ELSE 0 END) as jml_p
    FROM data_kk k 
    JOIN data_warga w ON k.no_kk = w.no_kk 
    WHERE k.rt = '$rt_user' AND k.rw = '$rw_user'");
$stats = mysqli_fetch_assoc($q_stats);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan_RT_<?= $rt_user ?>_<?= date('d_m_Y') ?></title>
    <style>
        /* Pengaturan Kertas A4 */
        @page {
            size: A4;
            margin: 0;
        }
        body {
            font-family: 'Times New Roman', Times, serif;
            margin: 0;
            padding: 0;
            background: #fff;
        }
        .paper {
            width: 210mm;
            padding: 20mm;
            margin: auto;
            box-sizing: border-box;
            page-break-after: always; /* Otomatis pindah halaman baru */
        }

        /* Kop Surat */
        .text-header {
            text-align: center;
            font-size: 14pt;
            font-weight: bold;
            text-transform: uppercase;
            line-height: 1.3;
            margin-bottom: 20px;
        }

        .section-title {
            font-weight: bold;
            text-decoration: underline;
            text-transform: uppercase;
            margin-top: 15px;
            font-size: 12pt;
        }

        /* Tabel Standar Laporan */
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
        th {
            background-color: #f2f2f2 !important;
            -webkit-print-color-adjust: exact;
        }

        .text-center { text-align: center; }
        .text-start { text-align: left; }
        .small-text { font-size: 10pt; }

        /* Tanda Tangan */
        .signature-container {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
            text-align: center;
        }

        /* Sembunyikan tombol saat print */
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body onload="window.print()">

<div class="no-print" style="background: #333; color: white; padding: 10px; text-align: center;">
    Halaman ini otomatis membuka dialog cetak. Jika tidak muncul, klik: 
    <button onclick="window.print()">Cetak / Simpan PDF</button>
    <a href="index.php" style="color: yellow; margin-left: 20px;">Kembali ke Dashboard</a>
</div>

<div class="paper">
    <div class="text-header">
        LAPORAN PELAYANAN / KEGIATAN KETUA RT / KETUA RW<br>
        PEMERINTAH KOTA PROBOLINGGO
    </div>

    <div style="text-align: center; margin-bottom: 20px; font-weight: bold;">
        Kelurahan : Curahgrinting &nbsp;&nbsp; Kecamatan : Kanigaran<br>
        Periode Laporan : <?= date('F Y'); ?>
    </div>

    <div class="section-title">A. DATA UMUM</div>
    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="45%">Uraian</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <tr><td class="text-center">1</td><td>Nama</td><td><?= $_SESSION['username']; ?></td></tr>
            <tr><td class="text-center">2</td><td>Jabatan</td><td>Ketua RT <?= $rt_user ?> / RW <?= $rw_user ?></td></tr>
            <tr><td class="text-center">3</td><td>Jumlah Kepala Keluarga</td><td><?= $stats['total_kk']; ?> KK</td></tr>
            <tr>
                <td class="text-center">4</td>
                <td>Jumlah Penduduk</td>
                <td>L: <?= $stats['jml_l']; ?> / P: <?= $stats['jml_p']; ?> / Total: <?= $stats['jml_l'] + $stats['jml_p']; ?> Jiwa</td>
            </tr>
            <tr><td class="text-center" rowspan="2">5</td><td>Jumlah Rumah</td><td>........ Unit</td></tr>
            <tr><td>Jumlah Tempat Ibadah</td><td>........ Unit</td></tr>
            <tr><td class="text-center" rowspan="2">6</td><td>Jumlah Posyandu</td><td>........ Unit</td></tr>
            <tr><td>Jumlah Poskamling</td><td>........ Unit</td></tr>
        </tbody>
    </table>

    <div class="section-title">B. KEGIATAN PENYELENGGARAAN TUGAS RT/RW (1-4)</div>
    <table>
        <thead>
            <tr class="text-center">
                <th>No</th>
                <th>Bidang</th>
                <th>Uraian Kegiatan</th>
                <th>Jml</th>
                <th>Satuan</th>
                <th>Output</th>
            </tr>
        </thead>
        <tbody>
            <tr><td rowspan="2">1</td><td rowspan="2">Adm. Kependudukan</td><td>Pendataan warga baru</td><td></td><td>Orang</td><td>Data Terupdate</td></tr>
            <tr><td>Layanan surat pengantar</td><td></td><td>Berkas</td><td>Surat Pengantar</td></tr>
            <tr><td>2</td><td>Keamanan</td><td>Ronda Malam / Mediasi</td><td></td><td>Kali</td><td>Lingkungan Aman</td></tr>
            <tr><td rowspan="2">3</td><td rowspan="2">Sosial</td><td>Penyaluran Bansos</td><td></td><td>Kegiatan</td><td>Tepat Sasaran</td></tr>
            <tr><td>Fasilitasi Data Sosial</td><td></td><td>Data</td><td>Data Terverifikasi</td></tr>
            <tr><td rowspan="2">4</td><td rowspan="2">Kesling</td><td>Program PHBS</td><td></td><td>Kegiatan</td><td>Sadar PHBS</td></tr>
            <tr><td>Kerja Bakti Lingkungan</td><td></td><td>Kali</td><td>Bersih & Sehat</td></tr>
        </tbody>
    </table>
</div>

<div class="paper">
    <table>
        <thead>
            <tr class="text-center">
                <th>No</th>
                <th>Bidang</th>
                <th>Uraian Kegiatan</th>
                <th>Jml</th>
                <th>Satuan</th>
                <th>Output</th>
            </tr>
        </thead>
        <tbody>
            <tr><td rowspan="3">5</td><td rowspan="3">Pendidikan & Ekonomi</td><td>Anak putus sekolah</td><td></td><td>Anak</td><td>Data Terupdate</td></tr>
            <tr><td>Pendataan UMKM</td><td></td><td>Unit</td><td>Data UMKM</td></tr>
            <tr><td>Sosialisasi PBB</td><td></td><td>Kali</td><td>Kepatuhan PBB</td></tr>
            <tr><td>6</td><td>Infrastruktur</td><td>Monitoring Jalan & PJU</td><td></td><td>Kegiatan</td><td>Fasum Terpelihara</td></tr>
            <tr><td>7</td><td>Partisipasi Prog.</td><td>Dukungan Prog. Kelurahan</td><td></td><td>Kegiatan</td><td>Sesuai Sasaran</td></tr>
            <tr><td>8</td><td>Inovasi</td><td>Kegiatan Tematik RT</td><td></td><td>Kegiatan</td><td>Partisipasi Naik</td></tr>
        </tbody>
    </table>

    <div class="section-title">C. REKAPITULASI PERMASALAHAN</div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Jenis Masalah</th>
                <th>Uraian</th>
                <th>Upaya / Status</th>
            </tr>
        </thead>
        <tbody>
            <tr><td class="text-center">1</td><td>Sosial / Konflik</td><td></td><td></td></tr>
            <tr><td class="text-center">2</td><td>Kebersihan</td><td></td><td></td></tr>
            <tr><td class="text-center">3</td><td>Bantuan Sosial</td><td></td><td></td></tr>
        </tbody>
    </table>

    <div class="signature-container">
        <div style="width: 250px;">
            Mengetahui,<br>Lurah Curahgrinting<br><br><br><br>
            ( <strong>Rois Hidayat S.Pd Mpd</strong> )<br>
            NIP. ...........................
        </div>
        <div style="width: 250px;">
            Probolinggo, <?= date('d F Y'); ?><br>Ketua RT <?= $rt_user ?><br><br><br><br>
            ( <strong><?= $_SESSION['username']; ?></strong> )
        </div>
    </div>
</div>

</body>
</html>