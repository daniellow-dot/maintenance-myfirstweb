<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bantuan Login - Lupa Password</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f6;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .card {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            text-align: center;
            max-width: 400px;
            width: 90%;
        }
        h2 { color: #333; margin-bottom: 10px; }
        p { color: #666; line-height: 1.6; }
        .contact-box {
            background-color: #e7f3ff;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            border: 1px solid #b3d7ff;
        }
        .wa-link {
            display: inline-block;
            background-color: #25D366;
            color: white;
            padding: 12px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin-top: 10px;
        }
        .wa-link:hover { background-color: #128C7E; }
        .back-link {
            display: block;
            margin-top: 20px;
            color: #007bff;
            text-decoration: none;
            font-size: 14px;
        }
    </style>
</head>
<body>

<div class="card">
    <h2>Lupa Password?</h2>
    <p>Jangan khawatir! Silakan hubungi Admin sistem kami untuk melakukan reset password akun Anda.</p>
    
    <div class="contact-box">
        <strong>Hubungi Admin via WhatsApp:</strong><br>
        <a href="https://wa.me/6281234567890?text=Halo%20Admin,%20saya%20lupa%20password%20akun%20saya" class="wa-link" target="_blank">
            Chat WhatsApp Admin
        </a>
        <p style="font-size: 13px; margin-top: 10px;">No. Telp Admin: <b>085791341388</b></p>
    </div>

    <p style="font-size: 12px; color: #999;">Mohon siapkan Nama Lengkap atau Username Anda untuk verifikasi identitas.</p>
    
    <a href="login.php" class="back-link">← Kembali ke Halaman Login</a>
</div>

</body>
</html>