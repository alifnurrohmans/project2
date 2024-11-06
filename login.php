<?php
include 'koneksi.php';
session_start();

// Di bagian atas file, sebelum form login untuk cookie dan session jika usdah ada
if (isset($_COOKIE['username'])) {
    $_SESSION['username'] = $_COOKIE['username'];
    $_SESSION['role'] = $_COOKIE['role'];
    header("Location: dashboard.php");
    exit();
}

if (isset($_SESSION['username'])) {
    header("Location: dashboard.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query untuk mendapatkan data pengguna
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // Verifikasi password
        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $user['role'];

            // Mengecek apakah checkbox "Remember Me" dicentang
            if (isset($_POST['remember_me'])) {
                // Mengatur cookie untuk 30 hari
                setcookie('username', $username, time() + (30 * 24 * 60 * 60), "/"); // 30 hari
                setcookie('role',  $user['role'], time() + (30 * 24 * 60 * 60), "/"); // 30 hari
            }

            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Username tidak ditemukan!";
    }
}

mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Perpustakaan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        .background {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url('img/bg-home.jpg');
            /* Gambar latar belakang */
            background-size: cover;
            background-position: center;
            z-index: 0;
            /* Di belakang form */
        }

        .form-container {
            background-color: rgba(255, 255, 255, 0.9);
            /* Warna latar belakang semi-transparan */
            padding: 20px 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 300px;
            text-align: center;
            position: relative;
            z-index: 1;
            /* Di atas background */
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
        }

        .btn {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #45a049;
        }

        .link {
            margin-top: 15px;
            display: block;
            color: #007bff;
            text-decoration: none;
        }

        .link:hover {
            text-decoration: underline;
        }

        p {
            color: red;
            font-size: 0.9rem;
        }
    </style>
</head>

<body>
    <div class="background"></div> <!-- Latar belakang -->
    <div class="form-container">
        <h2>Login Perpustakaan</h2>
        <?php if (isset($error)) echo "<p>$error</p>"; ?>
        <form action="" method="POST">
            <input type="text" name="username" placeholder="Username" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <label>
                <input type="checkbox" name="remember_me"> Remember me
            </label><br><br>
            <button type="submit" class="btn">Login</button>
        </form>
        <a class="link" href="register.php">Belum punya akun? Daftar di sini</a>
    </div>
</body>

</html>