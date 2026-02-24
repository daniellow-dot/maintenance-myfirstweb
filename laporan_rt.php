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
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Bulanan RT - Curahgrinting</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { 
            background-color: #f8f9fa; 
            font-family: 'Times New Roman', Times, serif; 
            font-size: 12pt;
        }
        
        /* Ukuran Kertas A4 */
        .paper { 
            background: white; 
            padding-top: 17.5mm;
            padding-right: 10mm;
            padding-bottom: 25.4mm;
            padding-left: 20mm;
            margin: 20px auto; 
            width: 210mm;
            min-height: 297mm;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            color: #000;
            line-height: 1.0;
            box-sizing: border-box;
            page-break-after: always;
            position: relative;
        }

        .text-header { 
            font-size: 14pt; 
            font-weight: bold; 
            text-align: center; 
            line-height: 1.2; 
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .section-title { 
            font-weight: bold; 
            margin-top: 15px; 
            margin-bottom: 5px;
            text-decoration: underline; 
            font-size: 12pt; 
            text-transform: uppercase;
        }

        .table-custom { 
            border: 1px solid black !important; 
            width: 100%; 
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .table-custom th, .table-custom td { 
            border: 1px solid black !important; 
            padding: 5px 8px; 
            vertical-align: middle;
            font-size: 12pt;
        }

        .table-custom th {
            background-color: #f2f2f2 !important;
            text-align: center;
        }

        .input-blank { 
            border: none; 
            border-bottom: 1px dotted black; 
            width: 95%; 
            outline: none; 
            background: transparent; 
            font-family: 'Times New Roman', Times, serif;
        }

        .signature-wrapper {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
            text-align: center;
        }

        @media print {
            body { background: white; margin: 0; padding: 0; }
            .no-print, .navbar, .filter-bar { display: none !important; }
            .paper { 
                margin: 0; 
                box-shadow: none; 
                width: 100%;
                min-height: auto;
            }
            .table-custom th { background-color: #f2f2f2 !important; -webkit-print-color-adjust: exact; }
        }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="text-center mt-4 no-print">
    <a href="download_laporan.php" class="btn btn-success px-4 me-2">
        <i class="bi bi-file-earmark-pdf"></i> Download Laporan
    </a>
    
    <button onclick="window.print()" class="btn btn-primary px-4 me-2">
        <i class="bi bi-printer"></i> Cetak Langsung
    </button>
    
    <a href="index.php" class="btn btn-outline-secondary px-4">Kembali</a>
</div>

<div class="paper">
    <div class="text-header">
        LAPORAN PELAYANAN / KEGIATAN<br>
        KETUA RT / KETUA RW<br>
        Pemerintah Kota Probolinggo
    </div>

    <div style="text-align: center; margin-bottom: 20px; font-weight: bold;">
        Kelurahan : Curahgrinting &nbsp;&nbsp; Kecamatan : Kanigaran<br>
        Periode Laporan : Bulan <?= date('F'); ?> &nbsp;&nbsp; Tahun <?= date('Y'); ?>
    </div>

    <div class="section-title">A. DATA UMUM</div>
    <table class="table-custom">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="40%">Uraian</th>
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
                <td>
                    L: <?= $stats['jml_l']; ?> / P: <?= $stats['jml_p']; ?> / Total: <?= $stats['jml_l'] + $stats['jml_p']; ?> Jiwa
                </td>
            </tr>
            <tr><td class="text-center" rowspan="2">5</td><td>Jumlah Rumah</td><td><input type="text" class="input-blank" placeholder="...... Unit"></td></tr>
            <tr><td>Jumlah Tempat Ibadah</td><td><input type="text" class="input-blank" placeholder="...... Unit"></td></tr>
            <tr><td class="text-center" rowspan="2">6</td><td>Jumlah Posyandu</td><td><input type="text" class="input-blank" placeholder="...... Unit"></td></tr>
            <tr><td>Jumlah Poskamling</td><td><input type="text" class="input-blank" placeholder="...... Unit"></td></tr>
        </tbody>
    </table>

    <div class="section-title">B. KEGIATAN PENYELENGGARAAN TUGAS RT/RW</div>
    <table class="table-custom text-center">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="18%">Bidang</th>
                <th width="22%">Uraian Kegiatan</th>
                <th width="8%">Jml</th>
                <th width="10%">Satuan</th>
                <th width="15%">Hasil</th>
                <th>Ket</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td rowspan="2">1</td>
                <td rowspan="2" class="text-start">Administrasi Kependudukan dan Pelayanan</td>
                <td class="text-start small">Pendataan warga baru Pindah Datang</td>
                <td><input type="text" class="input-blank text-center"></td>
                <td>Orang</td>
                <td class="small">Data warga ter-update</td>
                <td class="small">Jumlah warga pindah datang (Bukan sebagai basis data)</td>
            </tr>
            <tr>
                <td class="text-start small">Pelayanan surat pengantar</td>
                <td><input type="text" class="input-blank text-center"></td>
                <td>Berkas</td>
                <td class="small">Surat Pengantar</td>
                <td class="small">Jenis surat Pengantar</td>
            </tr>
            <tr>
                <td>2</td>
                <td class="text-start">Ketertiban & Keamanan</td>
                <td class="text-start small">Ronda malam, mediasi warga, koordinasi Linmas</td>
                <td><input type="text" class="input-blank text-center"></td>
                <td>Kali</td>
                <td class="small">Lingkungan aman dan tertib</td>
                <td class="small">Jenis kegiatan yang dilaksanakan</td>
            </tr>
            <tr>
                <td rowspan="2">3</td>
                <td rowspan="2" class="text-start">Sosial</td>
                <td class="text-start small">Fasilitasi Penyaluran Bantuan Sosial</td>
                <td><input type="text" class="input-blank text-center"></td>
                <td>Kegiatan</td>
                <td class="small">Meningkatnya ketepatan sasaran</td>
                <td class="small">Jenis Bantuan yang disalurkan</td>
            </tr>
            <tr>
                <td class="text-start small">Fasilitasi Data Sosial</td>
                <td><input type="text" class="input-blank text-center"></td>
                <td>Data</td>
                <td class="small">Data warga ter-update</td>
                <td class="small">Jenis Data Sosial yang diverikasi</td>
            </tr>
            <tr>
                <td rowspan="2">4</td>
                <td rowspan="2" class="text-start">Kesehatan & Lingk.</td>
                <td class="text-start small">Program kesehatan (PHBS)</td>
                <td><input type="text" class="input-blank text-center"></td>
                <td>Kegiatan</td>
                <td class="small">Sadar PHBS</td>
                <td class="small">Sosialisasi</td>
            </tr>
            <tr>
                <td class="text-start small">Kerja Bakti</td>
                <td><input type="text" class="input-blank text-center"></td>
                <td>Kali</td>
                <td class="small">Bersih</td>
                <td class="small">Lokasi</td>
            </tr>
            <tr>
                <td rowspan="3">5</td>
                <td rowspan="3" class="text-start">Pendidikan & Ekonomi</td>
                <td class="text-start small">Fasilitasi pendataan anak putus sekolah</td>
                <td><input type="text" class="input-blank text-center"></td>
                <td>Anak</td>
                <td class="small">Ter-update</td>
                <td class="small">Jumlah</td>
            </tr>
            <tr>
                <td class="text-start small">Fasilitasi pendataan UMKM</td> 
                <td><input type="text" class="input-blank text-center"></td>
                <td>Unit</td>
                <td class="small">Data UMKM</td>
                <td class="small">Jumlah</td>
            </tr>
            <tr>
                <td class="text-start small">Sosialisasi kepatuhan pembayaran PBB</td>
                <td><input type="text" class="input-blank text-center"></td>
                <td>Kali</td>
                <td class="small">Patuh PBB</td>
                <td class="small">Sosialisasi</td>
            </tr>
        </tbody>
    </table>
</div>

<div class="paper">
    <table class="table-custom text-center">
        <tbody>
            <tr>
                <td width="5%">6</td>
                <td width="18%" class="text-start">Infrastruktur</td>
                <td width="22%" class="text-start small">Monitoring jalan & PJU</td>
                <td width="8%"><input type="text" class="input-blank text-center"></td>
                <td width="10%">Kegiatan</td>
                <td width="15%" class="small">Terpelihara</td>
                <td>Monitoring</td>
            </tr>
            <tr>
                <td>7</td>
                <td class="text-start">Program Govt</td>
                <td class="text-start small">Dukungan kelurahan/SPM</td>
                <td><input type="text" class="input-blank text-center"></td>
                <td>Kegiatan</td>
                <td class="small">Sesuai sasaran</td>
                <td class="small">Nama prog</td>
            </tr>
            <tr>
                <td>8</td>
                <td class="text-start">Inovasi</td>
                <td class="text-start small">Inovasi lingkungan</td>
                <td><input type="text" class="input-blank text-center"></td>
                <td>Kegiatan</td>
                <td class="small">Partisipasi naik</td>
                <td class="small">Nama inovasi</td>
            </tr>
        </tbody>
    </table>

    <div class="section-title">C. REKAPITULASI PERMASALAHAN</div>
    <table class="table-custom">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th>Jenis Masalah</th>
                <th>Uraian</th>
                <th>Solusi</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <tr><td class="text-center">1</td><td class="small">Sosial</td><td><input type="text" class="input-blank"></td><td><input type="text" class="input-blank"></td><td><input type="text" class="input-blank"></td></tr>
            <tr><td class="text-center">2</td><td class="small">Lingkungan</td><td><input type="text" class="input-blank"></td><td><input type="text" class="input-blank"></td><td><input type="text" class="input-blank"></td></tr>
            <tr><td class="text-center">3</td><td class="small">Lain-lain</td><td><input type="text" class="input-blank"></td><td><input type="text" class="input-blank"></td><td><input type="text" class="input-blank"></td></tr>
        </tbody>
    </table>

    <div class="signature-wrapper">
        <div style="width: 45%;">
            Mengetahui,<br>Lurah Curahgrinting<br><br><br><br>
            ( <strong>Rois Hidayat S.Pd Mpd</strong> )<br>
            NIP. ...........................
        </div>
        <div style="width: 45%;">
            Probolinggo, <?= date('d F Y'); ?><br>Ketua RT <?= $rt_user ?><br><br><br><br>
            ( <strong><?= $_SESSION['username']; ?></strong> )
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>