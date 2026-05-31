<?php
session_start();
include 'koneksi.php';
$pesan = "";

if (isset($_POST['login'])) {
    $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
    $stmt->bind_param("s", $_POST['username']);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
    if ($user && password_verify($_POST['password'], $user['password']))
    {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        header("Location: index.php");
        exit;
    } else {
        $pesan = "<div class='alert alert-danger'>Username atau password salah.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 shadow" style="width: 350px;">
        <h3 class="text-center mb-4">Login Perpustakaan</h3>
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
            <button type="submit" name="login" class="btn btn-success w-100">Login</button>
        </form>
        <div class="mt-3 text-center">Belum punya akun? <a href="register.php">Daftar</a></div>
    </div>
</body>
</html>