<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id_warga = mysqli_real_escape_string($koneksi, $_GET['id']);

    // Proses Hapus - PERBAIKAN: Hapus data warga, bukan data_kk
    $query = "DELETE FROM data_warga WHERE id_warga = '$id_warga'";
    $hasil = mysqli_query($koneksi, $query);

    if ($hasil) {
        echo "<script>alert('Data Warga Berhasil Dihapus!'); window.location='data_warga.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus data: " . mysqli_error($koneksi) . "'); window.location='data_warga.php';</script>";
    }
} else {
    header("Location: data_warga.php");
}
?>