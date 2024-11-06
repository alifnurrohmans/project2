<?php
session_start();
include 'koneksi.php';

// Cek apakah user sudah login atau belum
if (!isset($_SESSION['username'])) {
    // Jika belum login, arahkan ke halaman login
    header("Location: login.php");
    exit();
}


$sql = "SELECT * FROM buku";
$result = mysqli_query($conn, $sql);
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
            margin-bottom: 10px;
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
        <h2>Daftar Buku</h2>
        <?php if ($_SESSION['role'] == 'admin') : ?>
            <a href="buku_tambah.php" class="tambah-button">Tambah buku</a>
        <?php endif; ?>
        <div class="books-container">
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <div class="book-card">
                    <img src="img_buku/<?php echo $row['gambar']; ?>" alt="Cover Buku 1">
                    <div class="card-content">
                        <h4>Judul : <?php echo $row['judul']; ?></h4>
                        <p>Penulis: <?php echo $row['penulis']; ?></p>
                        <a href="pdf_buku/<?php echo $row['filepdf']; ?>" download="<?php echo $row['filepdf']; ?>" class=" download-button">Download</a>
                        <?php if ($_SESSION['role'] == 'admin') : ?>
                            <hr style="margin: 10px;">
                            <a href="buku_edit.php?id=<?= $row['id'] ?>" class="download-button">Edit</a>
                            <a href="buku_hapus.php?id=<?= $row['id'] ?>" class="download-button">hapus</a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php } ?>
            <!-- Example Book Card -->

            <!-- Tambahkan book-card lainnya sesuai kebutuhan -->
        </div>
    </div>
</body>

</html>