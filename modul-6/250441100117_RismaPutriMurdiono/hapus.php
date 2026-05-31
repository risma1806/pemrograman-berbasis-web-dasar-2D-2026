<?php
include 'auth.php';
wajib_admin(); 
include 'koneksi.php';

if (!isset($_GET['id'])) die("ID tidak ditemukan!");
$id = (int)$_GET['id'];

$stmt = $conn->prepare("DELETE FROM buku WHERE id=?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: index.php");
    exit;
} else {
    echo "Gagal menghapus data!";
}
?>