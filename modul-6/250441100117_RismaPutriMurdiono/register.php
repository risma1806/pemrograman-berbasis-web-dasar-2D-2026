<?php
include 'koneksi.php';
$pesan = "";

if (isset($_POST['daftar'])) {
    $username = $_POST['username'];
    $hash = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password

    // Gunakan Prepared Statement
    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $hash);
    
    // Gunakan try...catch untuk menangani error MySQLi (khususnya PHP 8.1+)
    try {
        if ($stmt->execute()) {
            $pesan = "<div class='alert alert-success'>Registrasi berhasil! Silakan <a href='login.php'>Login</a></div>";
        }
    } catch (mysqli_sql_exception $e) {
        // Menangkap error kode 1062 (Duplicate Entry) dari MySQL
        if ($e->getCode() == 1062) {
            $pesan = "<div class='alert alert-danger'>Gagal mendaftar. Username sudah digunakan, silakan pilih yang lain.</div>";
        } else {
            // Menangkap error database lainnya
            $pesan = "<div class='alert alert-danger'>Terjadi kesalahan sistem: " . $e->getMessage() . "</div>";
        }
    }
    
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Registrasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 shadow" style="width: 350px;">
        <h3 class="text-center mb-4">Daftar Akun</h3>
        <?= $pesan; ?>
        <form method="POST">
            <div class="mb-3">
                <label>Username</label>
                <input type="text" class="form-control" name="username" required>
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            <button type="submit" name="daftar" class="btn btn-primary w-100">Daftar</button>
        </form>
        <div class="mt-3 text-center">Sudah punya akun? <a href="login.php">Login</a></div>
    </div>
</body>
</html>