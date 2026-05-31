<?php
include 'auth.php';
wajib_admin();
include 'koneksi.php';

if (!isset($_GET['id'])) die("ID tidak ditemukan!");
$id = (int)$_GET['id'];

$stmt = $conn->prepare("SELECT * FROM buku WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$buku = $stmt->get_result()->fetch_assoc();

if (!$buku) die("Data buku tidak ada.");

if (isset($_POST['update'])) {
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $tahun = (int)$_POST['tahun_terbit'];
    $kategori = $_POST['kategori'];
    $harga = (int)$_POST['harga'];

    $stmtUpdate = $conn->prepare("UPDATE buku SET judul=?, penulis=?, tahun_terbit=?, kategori=?, harga=? WHERE id=?");
    $stmtUpdate->bind_param("ssisii", $judul, $penulis, $tahun, $kategori, $harga, $id);
    
    if ($stmtUpdate->execute()) {
        header("Location: index.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Edit Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2>Edit Data Buku</h2>
    <form method="POST" class="mt-4" style="max-width: 500px;">
        <div class="mb-3">
            <label>Judul Buku</label>
            <input type="text" name="judul" class="form-control" value="<?= htmlspecialchars($buku['judul']); ?>" required>
        </div>
        <div class="mb-3">
            <label>Penulis</label>
            <input type="text" name="penulis" class="form-control" value="<?= htmlspecialchars($buku['penulis']); ?>" required>
        </div>
        <div class="mb-3">
            <label>Tahun Terbit</label>
            <input type="number" name="tahun_terbit" class="form-control" value="<?= $buku['tahun_terbit']; ?>" required>
        </div>
        <div class="mb-3">
            <label>Kategori</label>
            <select name="kategori" class="form-select" required>
                <option value="Fiksi" <?= ($buku['kategori'] == 'Fiksi') ? 'selected' : ''; ?>>Fiksi</option>
                <option value="Edukasi" <?= ($buku['kategori'] == 'Edukasi') ? 'selected' : ''; ?>>Edukasi</option>
                <option value="Teknologi" <?= ($buku['kategori'] == 'Teknologi') ? 'selected' : ''; ?>>Teknologi</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Harga (Rp)</label>
            <input type="number" name="harga" class="form-control" value="<?= $buku['harga']; ?>" required>
        </div>
        <button type="submit" name="update" class="btn btn-warning">Update Data</button>
        <a href="index.php" class="btn btn-secondary">Batal</a>
    </form>
</body>
</html>