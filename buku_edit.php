<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil data buku dari database berdasarkan ID
    $sql = "SELECT * FROM buku WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    $book = mysqli_fetch_assoc($result);

    if (!$book) {
        echo "Buku tidak ditemukan.";
        exit();
    }
} else {
    echo "ID buku tidak ditemukan.";
    exit();
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
            margin-bottom: 10px;
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

        .main-content form div input,
        .main-content form div img,
        .main-content form div a {
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
        <h2>Edit Buku</h2>
        <div class="books-container">
            <form action="buku_edit_proses.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $book['id']; ?>">

                <div>
                    <label for="judul">Judul Buku</label>
                    <p>:</p>
                    <input type="text" name="judul" id="judul" value="<?php echo $book['judul']; ?>" required>
                </div>

                <div>
                    <label for="penulis">Penulis</label>
                    <p>:</p>
                    <input type="text" name="penulis" id="penulis" value="<?php echo $book['penulis']; ?>" required>
                </div>

                <div>
                    <label>Gambar Saat Ini</label>
                    <p>:</p>
                    <img src="img_buku/<?php echo $book['gambar']; ?>" alt="Cover Buku" width="100">
                </div>

                <div>
                    <label for="gambar">Ganti Gambar (opsional)</label>
                    <p>:</p>
                    <input type="file" name="gambar" id="gambar" accept="image/*">
                </div>

                <div>
                    <label>File PDF Saat Ini</label>
                    <p>:</p>
                    <a href="pdf_buku/<?php echo $book['filepdf']; ?>" target="_blank">Download PDF</a>
                </div>

                <div>
                    <label for="filepdf">Ganti File PDF (opsional)</label>
                    <p>:</p>
                    <input type="file" name="filepdf" id="filepdf" accept="application/pdf">
                </div>

                <input class="download-button" type="submit" value="Update Buku">
            </form>
        </div>
    </div>
</body>

</html>