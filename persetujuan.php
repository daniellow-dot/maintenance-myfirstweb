<?php
session_start();
include 'koneksi.php';

// Proteksi: Hanya Admin yang bisa mengakses halaman ini
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// --- PROSES TOMBOL SETUJU / TOLAK ---
if (isset($_GET['aksi']) && isset($_GET['id'])) {
    $id = $_GET['id'];
    // Jika setuju status jadi 'aktif', jika tolak status jadi 'blokir'
    $status_baru = ($_GET['aksi'] == 'setuju') ? 'aktif' : 'blokir';
    
    $stmt = $koneksi->prepare("UPDATE pengguna SET status_akun = ? WHERE id_pengguna = ?");
    $stmt->bind_param("si", $status_baru, $id);
    
    if ($stmt->execute()) {
        echo "<script>alert('User berhasil diupdate!'); window.location='persetujuan.php';</script>";
    }
}

// Ambil data yang statusnya masih 'pending'
$query = mysqli_query($koneksi, "SELECT * FROM pengguna WHERE status_akun = 'pending'");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Persetujuan Akun - Curahgrinting</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        /* Reset beberapa style agar Tailwind & Bootstrap tidak bentrok */
        .navbar a { text-decoration: none !important; }
        body { font-size: 1rem; }
    </style>
</head>
<body class="bg-slate-50">

<?php include 'navbar.php'; ?>

<div class="p-6 mt-4">
    <div class="max-w-5xl mx-auto bg-white rounded-xl shadow-sm border border-slate-200 p-8">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-slate-800">Persetujuan Akun Baru</h2>
            <p class="text-slate-500 text-sm">Terdapat akun yang menunggu verifikasi untuk mengakses sistem Curahgrinting.</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-200 text-slate-400 text-xs uppercase tracking-wider">
                        <th class="p-4 font-semibold">Username</th>
                        <th class="p-4 font-semibold">Jabatan (Role)</th>
                        <th class="p-4 font-semibold">Wilayah</th>
                        <th class="p-4 font-semibold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-slate-700">
                    <?php while($row = mysqli_fetch_assoc($query)): ?>
                    <tr class="border-b border-slate-100 hover:bg-slate-50 transition">
                        <td class="p-4 font-bold text-blue-900"><?= $row['username'] ?></td>
                        <td class="p-4">
                            <span class="uppercase text-[10px] font-bold px-2 py-1 bg-blue-50 text-blue-700 rounded-md border border-blue-100">
                                <?= $row['role'] ?>
                            </span>
                        </td>
                        <td class="p-4 text-sm">RT <?= $row['rt'] ?> / RW <?= $row['rw'] ?></td>
                        <td class="p-4 text-center">
                            <div class="flex justify-center gap-2">
                                <a href="?aksi=setuju&id=<?= $row['id_pengguna'] ?>" 
                                   class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-bold flex items-center no-underline">
                                   <i class="bi bi-check-circle me-2"></i> Setujui
                                </a>
                                <a href="?aksi=tolak&id=<?= $row['id_pengguna'] ?>" 
                                   class="bg-white hover:bg-red-50 text-red-600 px-4 py-2 rounded-lg text-sm font-bold border border-red-200 flex items-center no-underline transition"
                                   onclick="return confirm('Apakah Anda yakin ingin menolak akun ini?')">
                                   <i class="bi bi-trash me-2"></i> Tolak
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                    
                    <?php if(mysqli_num_rows($query) == 0): ?>
                    <tr>
                        <td colspan="4" class="p-10 text-center text-slate-400">
                            <i class="bi bi-inbox text-4xl d-block mb-2"></i>
                            Tidak ada pendaftaran baru saat ini.
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="mt-8 pt-6 border-t border-slate-100">
            <a href="index.php" class="text-blue-600 font-bold hover:underline flex items-center no-underline">
                <i class="bi bi-arrow-left me-2"></i> Kembali ke Dashboard
            </a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>