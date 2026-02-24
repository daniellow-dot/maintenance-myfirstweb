<?php
include 'koneksi.php';

if (isset($_POST['simpan'])) {
    // Gunakan mysqli_real_escape_string untuk mencegah SQL Injection
    // dan menangani karakter khusus seperti tanda petik (')
    $no_kk            = mysqli_real_escape_string($koneksi, $_POST['no_kk']);
    $kepala_keluarga  = mysqli_real_escape_string($koneksi, $_POST['kepala_keluarga']);
    $alamat           = mysqli_real_escape_string($koneksi, $_POST['alamat']);
    $rt               = mysqli_real_escape_string($koneksi, $_POST['rt']);
    $rw               = mysqli_real_escape_string($koneksi, $_POST['rw']);
    $kode_pos         = mysqli_real_escape_string($koneksi, $_POST['kode_pos']);
    $kelurahan        = mysqli_real_escape_string($koneksi, $_POST['kelurahan']);
    $kecamatan        = mysqli_real_escape_string($koneksi, $_POST['kecamatan']);
    $kota        = mysqli_real_escape_string($koneksi, $_POST['kota']);
    $provinsi         = mysqli_real_escape_string($koneksi, $_POST['provinsi']);
    $tgl_terbit       = mysqli_real_escape_string($koneksi, $_POST['tgl_terbit']);

    // Query Insert
    $query = "INSERT INTO data_kk (no_kk, kepala_keluarga, alamat, rt, rw, kode_pos, kelurahan, kecamatan, kota, provinsi, tgl_terbit) 
              VALUES ('$no_kk', '$kepala_keluarga', '$alamat', '$rt', '$rw', '$kode_pos', '$kelurahan', '$kecamatan', '$kota', '$provinsi', '$tgl_terbit')";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>
                alert('Data Berhasil Disimpan!');
                window.location.href='data_kk.php';
              </script>";
    } else {
        // Menampilkan pesan error spesifik jika gagal
        echo "Error saat menyimpan: " . mysqli_error($koneksi);
    }
}
?>