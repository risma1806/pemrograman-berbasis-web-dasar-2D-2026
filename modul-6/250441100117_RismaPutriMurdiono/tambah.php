<?php
include 'auth.php';
wajib_admin(); // Hanya admin yang boleh akses
include 'koneksi.php';

if (isset($_POST['simpan'])) {
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $tahun = (int)$_POST['tahun_terbit'];
    $kategori = $_POST['kategori'];
    $harga = (int)$_POST['harga'];

    $stmt = $conn->prepare("INSERT INTO buku (judul, penulis, tahun_terbit, kategori, harga) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssisi", $judul, $penulis, $tahun, $kategori, $harga);
    
    if ($stmt->execute()) {
        header("Location: index.php");
        exit;
    } else {
        echo "<div class='alert alert-danger'>Gagal menyimpan data!</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Tambah Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2>Tambah Data Buku</h2>
    <form method="POST" class="mt-4" style="max-width: 500px;">
        <div class="mb-3">
            <label>Judul Buku</label>
            <input type="text" name="judul" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Penulis</label>
            <input type="text" name="penulis" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Tahun Terbit</label>
            <input type="number" name="tahun_terbit" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Kategori</label>
            <select name="kategori" class="form-select" required>
                <option value="Fiksi">Fiksi</option>
                <option value="Edukasi">Edukasi</option>
                <option value="Teknologi">Teknologi</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Harga (Rp)</label>
            <input type="number" name="harga" class="form-control" required>
        </div>
        <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
        <a href="index.php" class="btn btn-secondary">Batal</a>
    </form>
</body>
</html>