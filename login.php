<?php
session_start();
include 'koneksi.php'; // Pastikan $koneksi adalah objek mysqli

$error = '';

// --- PROSES LOGIN ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Ambil data POST
    $username = $_POST['username'];
    $password = $_POST['password'];

    // 2. Siapkan dan jalankan kueri aman (Prepared Statement)
    $stmt = $koneksi->prepare("SELECT * FROM pengguna WHERE username = ? AND status_akun = 'aktif'");
    
    if ($stmt === false) {
        $error = "Error: Gagal menyiapkan kueri.";
    } else {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $data = $result->fetch_assoc();

            // 3. Verifikasi Password
            if (password_verify($password, $data['password'])) {
                
                // Password BENAR! Simpan data ke SESSION
                $_SESSION['login'] = true;
                $_SESSION['id_pengguna'] = $data['id_pengguna'];
                $_SESSION['username'] = $data['username'];
                $_SESSION['role'] = $data['role']; 
                $_SESSION['rw'] = $data['rw'];
                $_SESSION['rt'] = $data['rt'] ?? null;

                // 4. ARAHKAN LANGSUNG KE index.php
                header("Location: index.php");
                exit; 

            } else {
                $error = "Username atau password salah!";
            }
        } else {
            $error = "Username salah, password salah, atau akun belum diaktifkan admin!";
        }
        $stmt->close(); 
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Login - Kelurahan Curahgrinting</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet"/> 
    
    <style>
        body {
            background: url('assets/login.png') no-repeat center center;
            background-size: cover;
            position: relative;
            min-height: 100vh;
        }
        body::before {
            content: "";
            position: absolute;
            inset: 0;
            background-color: rgba(0,0,0,0.4);
            z-index: 0;
        }
        .card-glass {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            position: relative;
            z-index: 10;
        }
        .input-field { background: #fff; color: #1a1a1a; transition: all 0.3s ease; }
        .input-field:focus { background: #f0f0f0; }
    </style>
</head>
<body class="flex flex-col text-gray-800">

<div id="loginModal" class="fixed inset-0 flex items-center justify-center z-50">
    <div class="card-glass rounded-xl p-8 max-w-md w-full mx-4 shadow-2xl">
        <div class="text-center mb-8">
            <img src="assets/logo1.png" alt="Logo RW CurahGrintingku" class="w-24 h-24 mx-auto rounded-full border-2 border-gray-600">
            <h1 class="text-2xl font-bold mt-4 text-gray-900">Curah Grinting</h1>
            <p class="text-gray-600">Silakan masuk untuk mengakses data</p>
        </div>

        <form method="POST" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-900 mb-1">Username</label>
                <input type="text" name="username" class="input-field w-full px-4 py-2 rounded-lg border border-gray-600 focus:border-gray-400 focus:outline-none" placeholder="Masukkan username" required>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-900 mb-1">Password</label>
                <div class="relative"> 
                    <input type="password" id="passwordField" name="password" class="input-field w-full px-4 py-2 rounded-lg border border-gray-600 focus:border-gray-400 focus:outline-none" placeholder="••••••••" required>
                    <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-600 hover:text-gray-900 focus:outline-none">
                        <i id="eyeIcon" class="fas fa-eye"></i> 
                    </button>
                </div>
                
                <div class="text-right mt-1">
                    <a href="bantuan_pasword.php" class="text-xs font-medium text-blue-600 hover:text-blue-800 transition duration-150">
                        Lupa Password?
                    </a>
                </div>
            </div> 

            <button type="submit" class="w-full bg-gray-800 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg transition duration-300">
                Masuk
            </button>

            <div class="pt-4 border-t border-gray-200 text-center">
                <p class="text-sm text-gray-600">
                    Belum punya akun? 
                    <a href="register.php" class="text-blue-600 font-bold hover:text-blue-800 transition duration-150">
                        Daftar Akun Baru
                    </a>
                </p>
            </div>
        </form>

        <?php if (!empty($error)): ?>
            <p class="text-red-600 text-center mt-4"><?= $error ?></p>
        <?php endif; ?>
    </div>
</div>

<script>
    document.getElementById('togglePassword').addEventListener('click', function (e) {
        const passwordField = document.getElementById('passwordField');
        const eyeIcon = document.getElementById('eyeIcon');
        
        const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordField.setAttribute('type', type);
        
        if (type === 'text') {
            eyeIcon.classList.remove('fa-eye');
            eyeIcon.classList.add('fa-eye-slash');
        } else {
            eyeIcon.classList.remove('fa-eye-slash');
            eyeIcon.classList.add('fa-eye');
        }
    });
</script>
</body>
</html>