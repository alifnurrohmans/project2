<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];

    // Ambil data buku lama untuk pengecekan file
    $sql = "SELECT * FROM buku WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    $book = mysqli_fetch_assoc($result);

    if (!$book) {
        echo "Buku tidak ditemukan.";
        exit();
    }

    // Proses upload gambar baru jika ada
    if (!empty($_FILES['gambar']['name'])) {
        $gambar = $_FILES['gambar']['name'];
        $gambar_tmp = $_FILES['gambar']['tmp_name'];

        // Hapus gambar lama jika ada
        if ($book['gambar'] && file_exists("img_buku/" . $book['gambar'])) {
            unlink("img_buku/" . $book['gambar']);
        }

        // Simpan gambar baru
        move_uploaded_file($gambar_tmp, "img_buku/" . $gambar);
    } else {
        $gambar = $book['gambar']; // Jika tidak ada file baru, gunakan gambar lama
    }

    // Proses upload file PDF baru jika ada
    if (!empty($_FILES['filepdf']['name'])) {
        $filepdf = $_FILES['filepdf']['name'];
        $filepdf_tmp = $_FILES['filepdf']['tmp_name'];

        // Hapus file PDF lama jika ada
        if ($book['filepdf'] && file_exists("pdf_buku/" . $book['filepdf'])) {
            unlink("pdf_buku/" . $book['filepdf']);
        }

        // Simpan file PDF baru
        move_uploaded_file($filepdf_tmp, "pdf_buku/" . $filepdf);
    } else {
        $filepdf = $book['filepdf']; // Jika tidak ada file baru, gunakan file PDF lama
    }

    // Update data buku di database
    $sql = "UPDATE buku SET judul='$judul', penulis='$penulis', gambar='$gambar', filepdf='$filepdf' WHERE id=$id";
    if (mysqli_query($conn, $sql)) {
        echo "<script>
        alert('Buku Berhasil diedit');
        window.location.href = 'dashboard.php'; // redirect jika diperlukan
        </script>";
    } else {
        echo "<script>
        alert('Gagal edit buku');
        window.location.href = 'dashboard.php'; // redirect jika diperlukan
        </script>";
    }
}
