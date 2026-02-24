<?php
// 1. PENGATURAN KEAMANAN SESI (Wajib di paling atas)
// Mengatur agar cookie sesi hanya bisa diakses melalui HTTP (mencegah pencurian lewat JS)
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 0); // Ubah ke 1 jika Anda sudah menggunakan HTTPS

session_start();

// 2. PROTEKSI HALAMAN & REDIRECT
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    // Menghapus semua data sesi jika terindikasi tidak valid
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit; // Menghentikan script sepenuhnya
}

// Mencegah Session Hijacking dengan memperbarui ID sesi secara berkala
if (!isset($_SESSION['last_regeneration'])) {
    session_regenerate_id(true);
    $_SESSION['last_regeneration'] = time();
} elseif (time() - $_SESSION['last_regeneration'] > 1800) { // regenerasi setiap 30 menit
    session_regenerate_id(true);
    $_SESSION['last_regeneration'] = time();
}

// 3. HEADER KEAMANAN TAMBAHAN
header("X-Frame-Options: DENY"); // Mencegah Clickjacking
header("X-XSS-Protection: 1; mode=block"); // Proteksi XSS tambahan di browser
header("X-Content-Type-Options: nosniff");

// 4. KONEKSI DAN QUERY (Data asli Anda tetap terjaga)
include 'koneksi.php';

// Statistik dari Database (Gunakan try-catch jika perlu keamanan lebih tinggi)
$q_kk = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM data_kk");
$total_kk = mysqli_fetch_assoc($q_kk)['total'] ?? 0;

$q_lk = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM data_warga WHERE jenis_kelamin = 'Laki-laki'");
$total_lk = mysqli_fetch_assoc($q_lk)['total'] ?? 0;

$q_pr = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM data_warga WHERE jenis_kelamin = 'Perempuan'");
$total_pr = mysqli_fetch_assoc($q_pr)['total'] ?? 0;

$total_warga = $total_lk + $total_pr;

$q_rt = mysqli_query($koneksi, "SELECT COUNT(DISTINCT rt) as total_rt, COUNT(DISTINCT rw) as total_rw FROM data_kk");
$res_wilayah = mysqli_fetch_assoc($q_rt);
$total_rt = $res_wilayah['total_rt'] ?? 0;
$total_rw = $res_wilayah['total_rw'] ?? 0;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    
    <title>Sistem Informasi Desa Curahgrinting</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8f9fa; color: #334155; }
        .card-stat { 
            border: 1px solid #e2e8f0; 
            border-radius: 16px; 
            transition: all 0.3s ease; 
            background: #ffffff;
        }
        .card-stat:hover { 
            transform: translateY(-8px); 
            box-shadow: 0 15px 30px -5px rgba(0,0,0,0.1); 
        }
        .icon-circle {
            width: 55px; height: 55px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.6rem; margin-bottom: 15px;
        }
        .bg-primary-soft { background-color: #eef2ff; color: #4338ca; }
        .bg-info-soft { background-color: #e0f2fe; color: #0369a1; }
        .bg-danger-soft { background-color: #fff1f2; color: #e11d48; }
        .bg-blue-dark { background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%); color: #fff; }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container py-5">
    <div class="row align-items-center mb-5">
        <div class="col-md-8">
            <h1 class="fw-bold text-dark">Ringkasan Data</h1>
            <p class="text-muted fs-5">Sistem Pengelolaan Kependudukan Desa Curahgrinting.</p>
        </div>
        <div class="col-md-4 text-md-end">
            <div class="p-3 bg-white rounded-4 shadow-sm d-inline-block border">
                <h5 class="fw-bold mb-1"><i class="bi bi-calendar-event me-2 text-primary"></i><?= htmlspecialchars(date('d M Y')); ?></h5>
                <span id="clock" class="badge bg-primary-soft text-primary px-3 py-2 fs-6">00:00:00 WIB</span>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-8">
            <div class="card card-stat p-5 border-0 bg-blue-dark shadow-lg">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h6 class="text-uppercase fw-bold text-white-50 small">Total Keseluruhan Penduduk</h6>
                        <h1 class="display-3 fw-bold text-white mb-0"><?= htmlspecialchars($total_warga); ?></h1>
                        <p class="text-white-50 mb-0 mt-3">Terdaftar di database pusat desa</p>
                    </div>
                    <div class="col-4 text-end">
                        <i class="bi bi-people text-white opacity-25" style="font-size: 6rem;"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="row g-3">
                <div class="col-12">
                    <div class="card card-stat p-3">
                        <div class="d-flex align-items-center">
                            <div class="icon-circle bg-info-soft me-3 mb-0">
                                <i class="bi bi-gender-male"></i>
                            </div>
                            <div>
                                <h6 class="text-uppercase fw-bold text-muted small mb-0">Laki-laki</h6>
                                <h3 class="fw-bold mb-0"><?= htmlspecialchars($total_lk); ?> <span class="fs-6 fw-normal text-muted">Jiwa</span></h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card card-stat p-3">
                        <div class="d-flex align-items-center">
                            <div class="icon-circle bg-danger-soft me-3 mb-0">
                                <i class="bi bi-gender-female"></i>
                            </div>
                            <div>
                                <h6 class="text-uppercase fw-bold text-muted small mb-0">Perempuan</h6>
                                <h3 class="fw-bold mb-0"><?= htmlspecialchars($total_pr); ?> <span class="fs-6 fw-normal text-muted">Jiwa</span></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card card-stat h-100 p-4">
                <div class="icon-circle bg-primary-soft">
                    <i class="bi bi-house-door"></i>
                </div>
                <h6 class="text-uppercase fw-bold text-muted small">Total Kepala Keluarga</h6>
                <h2 class="fw-bold mb-0"><?= htmlspecialchars($total_kk); ?> <span class="fs-6 fw-normal text-muted">Keluarga</span></h2>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card card-stat h-100 p-4">
                <div class="icon-circle bg-light text-secondary">
                    <i class="bi bi-geo-alt"></i>
                </div>
                <h6 class="text-uppercase fw-bold text-muted small">Cakupan Wilayah</h6>
                <h2 class="fw-bold mb-0"><?= htmlspecialchars($total_rt); ?> <span class="fs-6 fw-normal text-muted">RT</span> / <?= htmlspecialchars($total_rw); ?> <span class="fs-6 fw-normal text-muted">RW</span></h2>
            </div>
        </div>
    </div>
</div>

<footer class="py-4 text-center text-muted small mt-5 border-top bg-white">
    &copy; <?= htmlspecialchars(date('Y')); ?> Desa Curahgrinting - Admin Dashboard
</footer>

<script>
    function updateClock() {
        const now = new Date();
        const options = { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false };
        const timeStr = now.toLocaleTimeString('id-ID', options);
        document.getElementById('clock').textContent = timeStr + ' WIB';
    }
    setInterval(updateClock, 1000);
    updateClock();
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>