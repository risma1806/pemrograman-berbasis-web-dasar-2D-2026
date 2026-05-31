<?php
include 'auth.php';
include 'koneksi.php';

$sql = "SELECT * FROM buku ORDER BY id DESC";
$result = $conn->query($sql);
$isAdmin = ($_SESSION['role'] === 'admin'); // Cek role untuk menyembunyikan tombol
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Manajemen Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Daftar Buku</h2>
        <div>
            <span class="me-3">Halo, <b><?= htmlspecialchars($_SESSION['username']); ?></b> (<?= $_SESSION['role']; ?>)</span>
            <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
        </div>
    </div>

    <?php if ($isAdmin): ?>
        <a href="tambah.php" class="btn btn-primary mb-3">+ Tambah Buku</a>
    <?php endif; ?>

    <?php if ($isAdmin): ?>
        <a href="edit.php" class="btn btn-warning mb-3 ">> Edit Buku</a>
    <?php endif; ?>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Judul Buku</th>
                <th>Penulis</th>
                <th>Tahun</th>
                <th>Kategori</th>
                <th>Harga (Rp)</th>
                <?php if ($isAdmin): ?><th>Aksi</th><?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            while ($row = $result->fetch_assoc()): 
            ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= htmlspecialchars($row['judul']); ?></td>
                <td><?= htmlspecialchars($row['penulis']); ?></td>
                <td><?= htmlspecialchars($row['tahun_terbit']); ?></td>
                <td><?= htmlspecialchars($row['kategori']); ?></td>
                <td><?= number_format($row['harga'], 0, ',', '.'); ?></td>
                
                <?php if ($isAdmin): ?>
                <td>
                    <a href="edit.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="hapus.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus buku ini?')">Hapus</a>
                </td>
                <?php endif; ?>
            </tr>
            <?php endwhile; ?>
            
            <?php if ($result->num_rows == 0): ?>
            <tr><td colspan="7" class="text-center">Belum ada data buku.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>