<?php
include 'koneksi.php'; // File untuk koneksi ke database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];

    // Upload gambar
    $gambar = $_FILES['gambar']['name'];
    $gambar_tmp = $_FILES['gambar']['tmp_name'];
    move_uploaded_file($gambar_tmp, "img_buku/" . $gambar);

    // Upload file PDF
    $filepdf = $_FILES['filepdf']['name'];
    $filepdf_tmp = $_FILES['filepdf']['tmp_name'];
    move_uploaded_file($filepdf_tmp, "pdf_buku/" . $filepdf);

    // Insert ke database
    $sql = "INSERT INTO buku (judul, penulis, gambar, filepdf) VALUES ('$judul', '$penulis', '$gambar', '$filepdf')";
    if (mysqli_query($conn, $sql)) {
        echo "<script>
        alert('Buku Berhasil ditambah');
        window.location.href = 'dashboard.php'; // redirect jika diperlukan
        </script>";
    } else {
        echo "<script>
        alert('Gagal menambah buku');
        window.location.href = 'dashboard.php'; // redirect jika diperlukan
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Perpustakaan</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        body {
            display: flex;
            height: 100vh;
            background-color: #f3f3f3;
        }

        /* Sidebar Style */
        .sidebar {
            width: 200px;
            background-color: #333;
            color: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 20px;
            position: fixed;
            height: 100vh;
        }

        .sidebar h2 {
            margin-bottom: 30px;
            font-size: 1.5rem;
        }

        .sidebar a {
            color: #fff;
            text-decoration: none;
            padding: 10px 20px;
            width: 100%;
            text-align: center;
            margin: 10px 0;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .sidebar a:hover {
            background-color: #575757;
        }

        .sidebar .view-books {
            background-color: #4CAF50;
        }

        .sidebar .manage-books {
            background-color: #2196F3;
        }

        .sidebar .manage-users {
            background-color: #FF5722;
        }

        /* Main Content Style */
        .main-content {
            margin-left: 200px;
            padding: 20px;
            width: calc(100% - 200px);
            position: relative;
        }

        /* Logout Button */
        .logout {
            position: absolute;
            right: 20px;
            top: 20px;
        }

        .logout a {
            color: #333;
            text-decoration: none;
            font-size: 0.9rem;
            background-color: #ff4d4d;
            padding: 8px 12px;
            border-radius: 4px;
            color: white;
            transition: background-color 0.3s;
        }

        .logout a:hover {
            background-color: #ff3333;
        }

        /* Card Style for Books */
        .books-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 40px;
        }

        .book-card {
            width: 220px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            text-align: center;
            transition: transform 0.3s;
        }

        .book-card:hover {
            transform: translateY(-5px);
        }

        .book-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .book-card .card-content {
            padding: 15px;
        }

        .book-card h3 {
            font-size: 1.2rem;
            color: #333;
            margin: 10px 0 5px;
        }

        .book-card p {
            font-size: 0.9rem;
            color: #666;
        }

        .download-button {
            display: inline-block;
            margin-top: 10px;
            padding: 8px 12px;
            background-color: #2196F3;
            color: white;
            border-radius: 4px;
            text-decoration: none;
            font-size: 0.9rem;
            transition: background-color 0.3s;
        }

        .tambah-button {
            display: inline-block;
            margin-top: 10px;
            padding: 8px 12px;
            background-color: blueviolet;
            color: white;
            border-radius: 4px;
            text-decoration: none;
            font-size: 0.9rem;
            transition: background-color 0.3s;
        }

        .tambah-button:hover {
            background-color: purple;
        }

        .download-button:hover {
            background-color: #1b7ec2;
        }

        .main-content form div {
            margin: 20px 0;
            width: 500px;
            display: flex;
            justify-content: space-between;
        }

        .main-content form div label {
            width: 45%;
        }

        .main-content form div p {
            width: 10%;
        }

        .main-content form div input {
            width: 45%;
        }
    </style>
</head>

<body>
    <!-- Sidebar Menu -->
    <div class="sidebar">
        <h2>Dashboard</h2>
        <a href="dashboard.php" class="view-books">Lihat Buku</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="logout">
            <a href="logout.php">Logout</a>
        </div>
        <h2>Tambah Buku Baru</h2>
        <div class="books-container">
            <form action="" method="POST" enctype="multipart/form-data">
                <div>
                    <label for="judul">Judul Buku</label>
                    <p>:</p>
                    <input type="text" name="judul" id="judul" required>
                </div>

                <div>
                    <label for="penulis">Penulis</label>
                    <p>:</p>
                    <input type="text" name="penulis" id="penulis" required>
                </div>

                <div>
                    <label for="gambar">Upload Gambar</label>
                    <p>:</p>
                    <input type="file" name="gambar" id="gambar" accept="image/*" required>
                </div>

                <div>
                    <label for="filepdf">Upload File PDF</label>
                    <p>:</p>
                    <input type="file" name="filepdf" id="filepdf" accept="application/pdf" required>
                </div>

                <input class="download-button" type="submit" value="Tambah Buku">
            </form>
        </div>
    </div>
</body>

</html>