<?php
session_start();
session_unset();
session_destroy();

// Hapus cookie username jika ada
if (isset($_COOKIE['username'])) {
    setcookie('username', '', time() - 3600, "/"); // Set waktu kedaluwarsa di masa lalu
}

// Hapus cookie username jika ada
if (isset($_COOKIE['role'])) {
    setcookie('role', '', time() - 3600, "/"); // Set waktu kedaluwarsa di masa lalu
}

// Arahkan kembali ke halaman login
header("Location: login.php");
exit();
