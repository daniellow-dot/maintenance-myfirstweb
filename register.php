<?php
include 'koneksi.php';

if (isset($_POST['register'])) {
    // 1. Sanitasi input dasar
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $role     = $_POST['role'];
    $rw       = $_POST['rw'];
    $rt       = $_POST['rt'];
    
    // 2. Validasi Keamanan: Minimal Panjang Password
    if (strlen($password) < 8) {
        echo "<script>alert('Keamanan Lemah: Password minimal 8 karakter!'); window.history.back();</script>";
        exit;
    }

    // 3. Hash password (BCRYPT)
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // 4. Prepared Statement untuk cek username (Cegah SQL Injection)
    $stmt_cek = $koneksi->prepare("SELECT username FROM pengguna WHERE username = ?");
    $stmt_cek->bind_param("s", $username);
    $stmt_cek->execute();
    $result_cek = $stmt_cek->get_result();
    
    if ($result_cek->num_rows > 0) {
        echo "<script>alert('Username sudah terdaftar! Gunakan nama lain.'); window.history.back();</script>";
    } else {
        // 5. Simpan dengan status_akun 'pending' (Keamanan Berlapis)
        // Pastikan Anda sudah menjalankan perintah SQL: 
        // ALTER TABLE pengguna ADD COLUMN status_akun ENUM('pending','aktif','blokir') DEFAULT 'pending';
        $status_awal = 'pending'; 
        
        $stmt_ins = $koneksi->prepare("INSERT INTO pengguna (username, password, role, rw, rt, status_akun) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt_ins->bind_param("ssssss", $username, $hashed_password, $role, $rw, $rt, $status_awal);
        
        if ($stmt_ins->execute()) {
            echo "<script>alert('Registrasi Berhasil! Akun Anda sedang ditinjau oleh Admin. Silahkan tunggu aktivasi.'); window.location='login.php';</script>";
        } else {
            echo "<script>alert('Terjadi kesalahan sistem.');</script>";
        }
        $stmt_ins->close();
    }
    $stmt_cek->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Curahgrinting</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet"/>
    <style>
        body {
            background: url('assets/login.png') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
        }
        .card-glass {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }
    </style>
</head>
<body class="flex items-center justify-center p-4">

<div class="card-glass rounded-xl p-8 max-w-md w-full shadow-2xl my-10">
    <div class="text-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Daftar Akun Baru</h1>
        <p class="text-sm text-gray-600">Sistem Informasi Curahgrinting</p>
    </div>

    <form method="POST" class="space-y-4">
        <div>
            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Username</label>
            <input type="text" name="username" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Buat username unik" required>
        </div>

        <div>
            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Password</label>
            <input type="password" name="password" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Minimal 8 karakter" required>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">RW</label>
                <input type="text" name="rw" maxlength="3" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 outline-none" placeholder="000" required>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">RT</label>
                <input type="text" name="rt" maxlength="3" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 outline-none" placeholder="000" required>
            </div>
        </div>

        <div>
            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Jabatan / Role</label>
            <select name="role" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 outline-none" required>
                <option value="rt">Ketua RT</option>
                <option value="rw">Ketua RW</option>
            </select>
        </div>

        <button type="submit" name="register" class="w-full bg-blue-700 hover:bg-blue-800 text-white font-bold py-3 rounded-lg transition duration-300 shadow-md">
            DAFTAR SEKARANG
        </button>

        <div class="text-center pt-2">
            <a href="login.php" class="text-sm text-blue-600 hover:underline">Kembali ke Login</a>
        </div>
    </form>
</div>

</body>
</html>