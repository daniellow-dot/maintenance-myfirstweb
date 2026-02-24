<?php
session_start();

// Hanya hapus session jika ada
if (isset($_SESSION['username']) || isset($_SESSION['logged_in'])) {
    // Hapus semua session
    $_SESSION = [];
    session_unset();
    session_destroy();
}

// Redirect ke halaman login
header("Location: login.php");
exit;
?>
