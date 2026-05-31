<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

function wajib_admin() {
    if ($_SESSION['role'] !== 'admin') {
        die("<div class='alert alert-danger'>Akses ditolak. Halaman ini hanya untuk admin. <a href='index.php'>Kembali</a></div>");
    }
}
?>