<?php
include 'koneksi.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontak - Kelurahan Curahgrinting</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        body {
            font-family: 'Inter', system-ui, sans-serif;
            background-color: #f8f9fa;
            color: #334155;
        }

        /* Card Container KK asli Anda */
        .kk-wrapper {
            background: #ffffff;
            padding: 32px;
            margin-bottom: 40px;
            border-radius: 14px;
            box-shadow: 0 10px 25px rgba(0,0,0,.08);
            border: 1px solid #e5e7eb;
        }

        .kk-title {
            text-align: center;
            font-weight: 700;
            font-size: 1.4rem;
            letter-spacing: 1px;
            margin-bottom: 2px;
            color: #1e293b;
        }

        .kk-subtitle {
            text-align: center;
            font-weight: 500;
            font-size: 0.95rem;
            color: #64748b;
            margin-bottom: 24px;
        }

        .info-section {
            background: #f1f5f9;
            border-radius: 10px;
            padding: 16px;
            margin-bottom: 20px;
            border: 1px solid #e2e8f0;
        }

        .label-cell {
            font-weight: 600;
            color: #475569;
            width: 150px;
        }

        /* Styling Tambahan untuk Map */
        .map-container {
            border-radius: 10px;
            overflow: hidden;
            border: 1px solid #e2e8f0;
            height: 100%;
            min-height: 400px;
        }

        .btn-primary-custom {
            background-color: #1e293b;
            border-color: #1e293b;
            color: white;
            font-weight: 600;
            padding: 10px 25px;
        }

        @media print {
            .no-print, nav { display: none !important; }
            body { background: white; }
            .kk-wrapper { box-shadow: none; border: 1px solid #000; page-break-after: always; }
        }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container mt-5">
    <div class="kk-wrapper">
        <div class="kk-title">KONTAK & LOKASI PELAYANAN</div>
        <div class="kk-subtitle">Pemerintah Kota Probolinggo - Kelurahan Curahgrinting</div>
        
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="info-section">
                    <h5 class="fw-bold mb-3"><i class="bi bi-geo-alt-fill me-2 text-primary"></i>Informasi Kantor</h5>
                    <div class="row mb-2">
                        <div class="col-4 label-cell">Alamat</div>
                        <div class="col-8">: Jl. Citarum No. 01, Curahgrinting</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4 label-cell">Telepon</div>
                        <div class="col-8">: (0335) 422080</div>
                    </div>
                    <div class="row">
                        <div class="col-4 label-cell">Email</div>
                        <div class="col-8">: curahgrinting@probolinggokota.go.id</div>
                    </div>
                </div>

                <div class="p-2">
                    <h5 class="fw-bold mb-3"><i class="bi bi-chat-dots-fill me-2 text-primary"></i>Kirim Pesan</h5>
                    <?php 
                    if (isset($_POST['kirim_pesan'])) {
                        echo "<div class='alert alert-success py-2'><small>Pesan berhasil dikirim!</small></div>";
                    }
                    ?>
                    <form action="" method="POST">
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control form-control-sm" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Email</label>
                            <input type="email" name="email" class="form-control form-control-sm" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Pesan</label>
                            <textarea name="pesan" class="form-control form-control-sm" rows="4" required></textarea>
                        </div>
                        <button type="submit" name="kirim_pesan" class="btn btn-primary-custom btn-sm w-100 shadow-sm">
                            <i class="bi bi-send me-2"></i>Kirim Pesan
                        </button>
                    </form>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="map-container shadow-sm">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3953.284242699317!2d113.20455437402633!3d-7.759664576953932!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7adc000000001%3A0xc6c4f9f4a0a0a0a0!2sKelurahan%20Curahgrinting!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid" 
                        width="100%" 
                        height="100%" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</div>

<footer class="text-center py-4 text-muted">
    <small>© 2025 Pemerintah Kelurahan Curahgrinting. All Rights Reserved.</small>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>