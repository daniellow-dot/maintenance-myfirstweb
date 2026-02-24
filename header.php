<?php
session_start();

// Cek apakah session login ada
if (!isset($_SESSION['login'])) {
    // Jika tidak ada, paksa user ke halaman login
    header("Location: login.php");
    exit;
}
?>