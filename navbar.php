<?php
// Mendapatkan nama file halaman saat ini untuk logika 'active' dan filter
$current_page = basename($_SERVER['PHP_SELF']);

// Inisialisasi variabel untuk menghindari error jika koneksi bermasalah
$jumlah_pending = 0;

// Ambil daftar RT dan RW secara dinamis dari database (Jika koneksi sudah ada)
if (isset($koneksi)) {
    $list_rt = mysqli_query($koneksi, "SELECT DISTINCT rt FROM data_kk WHERE rt != '' ORDER BY rt ASC");
    $list_rw = mysqli_query($koneksi, "SELECT DISTINCT rw FROM data_kk WHERE rw != '' ORDER BY rw ASC");

    // LOGIKA BARU: Hitung jumlah akun yang masih 'pending' untuk badge notifikasi
    $query_pending = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM pengguna WHERE status_akun = 'pending'");
    if ($query_pending) {
        $data_pending = mysqli_fetch_assoc($query_pending);
        $jumlah_pending = $data_pending['total'];
    }
}

// Tangkap filter dari URL
$f_rt = isset($_GET['rt']) ? $_GET['rt'] : '';
$f_rw = isset($_GET['rw']) ? $_GET['rw'] : '';
?>

<style>
    /* 1. Style Kustom Tombol dan Navbar (KODE ASLI KAMU - TETAP UTUH) */
    .navbar { 
        background: #1e40af !important; 
        border-bottom: 2px solid rgba(255,255,255,0.1); 
        padding: 12px 0; 
    }
    
    .navbar-brand { font-size: 1.4rem; color: #ffffff !important; font-weight: 700; }
    
    .nav-link { 
        color: rgba(255, 255, 255, 0.8) !important; 
        font-weight: 500; 
        transition: all 0.3s; 
        padding: 0.6rem 1.2rem !important; 
    }
    
    .nav-link:hover { 
        color: #ffffff !important; 
        background: rgba(255, 255, 255, 0.15); 
        border-radius: 8px; 
    }
    
    .nav-link.active { 
        color: #ffffff !important; 
        background: rgba(255, 255, 255, 0.25); 
        border-radius: 8px; 
        font-weight: 600;
    }
    
    .btn-add { 
        background-color: #ffffff !important; 
        color: #1e40af !important; 
        border: none !important; 
        border-radius: 10px !important; 
        padding: 8px 18px !important; 
        font-weight: 700 !important; 
        font-size: 0.9rem !important;
    }
    
    .btn-add:hover { background-color: #f1f5f9 !important; color: #000616ff !important; }

    .navbar-toggler { border-color: rgba(255,255,255,0.5) !important; }
    .navbar-toggler-icon {
        background-image: url("data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 32 32' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='rgba(255,255,255, 0.8)' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 8h24M4 16h24M4 24h24'/%3E%3C/svg%3E") !important;
    }

    /* Style Tambahan untuk Bar Filter */
    .filter-bar {
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        padding: 8px 0;
    }
    .form-select-filter {
        border-radius: 8px;
        font-size: 0.85rem;
        border: 1px solid #cbd5e1;
        padding: 5px 30px 5px 12px;
        cursor: pointer;
    }
    .form-select-filter:focus {
        border-color: #1e40af;
        box-shadow: 0 0 0 2px rgba(30, 64, 175, 0.1);
    }

    /* Badge Notifikasi Khusus */
    .badge-notif {
        font-size: 0.7rem;
        padding: 0.35em 0.65em;
        margin-left: 5px;
        vertical-align: middle;
    }
</style>

<nav class="navbar navbar-expand-lg sticky-top shadow">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="index.php">
            <i class="bi bi-shield-check me-2"></i>Curahgrinting
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link <?= ($current_page == 'index.php') ? 'active' : ''; ?>" href="index.php">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($current_page == 'data_kk.php') ? 'active' : ''; ?>" href="data_kk.php">Data KK</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($current_page == 'data_warga.php') ? 'active' : ''; ?>" href="data_warga.php">Daftar Warga</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($current_page == 'laporan_rt.php') ? 'active' : ''; ?>" href="laporan_rt.php">Laporan Bulanan</a>
                </li>

                <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') : ?>
                <li class="nav-item">
                    <a class="nav-link <?= ($current_page == 'persetujuan.php') ? 'active' : ''; ?>" href="persetujuan.php"> Persetujuan</a>
                        <?php if ($jumlah_pending > 0) : ?>
                            <span class="badge rounded-pill bg-danger badge-notif"><?= $jumlah_pending ?></span>
                        <?php endif; ?>
                    </a>
                </li>
                <?php endif; ?>

                <li class="nav-item">
                    <a class="nav-link <?= ($current_page == 'kontak.php') ? 'active' : ''; ?>" href="kontak.php">Kontak</a>
                </li>
            </ul>
            
            <div class="d-flex align-items-center mt-3 mt-lg-0">
                <div class="dropdown me-3">
                    <button class="btn btn-add dropdown-toggle shadow-sm" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-plus-lg me-1"></i> Input Data
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg mt-3">
                        <li><a class="dropdown-item py-2" href="tambah_kk.php"><i class="bi bi-folder-plus me-2 text-primary"></i>Kartu Keluarga</a></li>
                        <li><a class="dropdown-item py-2" href="tambah_data_warga.php"><i class="bi bi-person-plus me-2 text-primary"></i>Anggota Warga</a></li>
                    </ul>
                </div>
                <a href="logout.php" class="btn btn-outline-light border-0" title="Keluar">
                    <i class="bi bi-box-arrow-right fs-5"></i>
                </a>
            </div>
        </div>
    </div>
</nav>

<?php if ($current_page == 'data_kk.php' || $current_page == 'data_warga.php') : ?>
<div class="filter-bar no-print">
    <div class="container">
        <form method="GET" action="" class="row g-2 align-items-center">
            <div class="col-auto">
                <span class="small fw-bold text-secondary"><i class="bi bi-funnel-fill me-1"></i> FILTER WILAYAH:</span>
            </div>
            
            <div class="col-auto">
                <select name="rw" class="form-select form-select-filter" onchange="this.form.submit()">
                    <option value="">Semua RW</option>
                    <?php if (isset($list_rw)) {
                        mysqli_data_seek($list_rw, 0); 
                        while($rw = mysqli_fetch_assoc($list_rw)): ?>
                        <option value="<?= $rw['rw']; ?>" <?= ($f_rw == $rw['rw']) ? 'selected' : ''; ?>>RW <?= $rw['rw']; ?></option>
                    <?php endwhile; } ?>
                </select>
            </div>

            <div class="col-auto">
                <select name="rt" class="form-select form-select-filter" onchange="this.form.submit()">
                    <option value="">Semua RT</option>
                    <?php if (isset($list_rt)) {
                        mysqli_data_seek($list_rt, 0); 
                        while($rt = mysqli_fetch_assoc($list_rt)): ?>
                        <option value="<?= $rt['rt']; ?>" <?= ($f_rt == $rt['rt']) ? 'selected' : ''; ?>>RT <?= $rt['rt']; ?></option>
                    <?php endwhile; } ?>
                </select>
            </div>

            <?php if($f_rt != '' || $f_rw != ''): ?>
            <div class="col-auto">
                <a href="<?= $current_page; ?>" class="btn btn-sm btn-link text-danger text-decoration-none small">
                    <i class="bi bi-x-circle-fill"></i> Hapus Filter
                </a>
            </div>
            <?php endif; ?>
        </form>
    </div>
</div>
<?php endif; ?>