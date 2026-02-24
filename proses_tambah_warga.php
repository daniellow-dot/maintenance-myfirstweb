<?php
include 'koneksi.php';

if (isset($_POST['simpan'])) {
    $no_kk             = $_POST['no_kk'];
    $nama_lengkap      = strtoupper($_POST['nama_lengkap']);
    $nik               = $_POST['nik'];
    $jenis_kelamin     = $_POST['jenis_kelamin'];
    $tempat_lahir      = $_POST['tempat_lahir'];
    $tgl_lahir         = $_POST['tgl_lahir'];
    $agama             = $_POST['agama'];
    $pendidikan        = $_POST['pendidikan'];
    $jenis_pekerjaan   = $_POST['jenis_pekerjaan'];
    $status_perkawinan = $_POST['status_perkawinan'];
    $status_hubungan   = $_POST['status_hubungan'];
    $kewarganegaraan   = $_POST['kewarganegaraan'];
    $no_paspor         = $_POST['no_paspor'];
    $no_kitab          = $_POST['no_kitab'];
    $nama_ayah         = strtoupper($_POST['nama_ayah']);
    $nama_ibu          = strtoupper($_POST['nama_ibu']);

    $query = "INSERT INTO data_warga (no_kk, nama_lengkap, nik, jenis_kelamin, tempat_lahir, tgl_lahir, agama, pendidikan, jenis_pekerjaan, status_perkawinan, status_hubungan, kewarganegaraan, no_paspor, no_kitab, nama_ayah, nama_ibu) 
              VALUES ('$no_kk', '$nama_lengkap', '$nik', '$jenis_kelamin', '$tempat_lahir', '$tgl_lahir', '$agama', '$pendidikan', '$jenis_pekerjaan', '$status_perkawinan', '$status_hubungan', '$kewarganegaraan', '$no_paspor', '$no_kitab', '$nama_ayah', '$nama_ibu')";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Data Warga Berhasil Ditambahkan!'); window.location.href='data_warga.php';</script>";
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}
?>