<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM buku WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
        alert('Buku Berhasil dihapus');
        window.location.href = 'dashboard.php'; // redirect jika diperlukan
        </script>";
    } else {
        echo "<script>
        alert('Gagal menghapus buku');
        window.location.href = 'dashboard.php'; // redirect jika diperlukan
        </script>";
    }
}
