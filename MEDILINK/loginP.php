<?php
session_start();
include 'koneksi.php';

// Jika sudah login, redirect ke halaman utama
if(isset($_SESSION['id_pengguna'])) {
    // header("Location: indexP.php");
    // exit();
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>MEDILINK LOGIN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background: linear-gradient(135deg, #386fd3,rgb(50, 149, 255));
            color: #fff;
            font-family: 'Roboto', sans-serif;
        }
        .form-signin {
            background: #fff;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 360px;
            width: 100%;
            color: #333;
        }
        .form-signin .btn-primary {
            background: #386fd3;
            border: none;
        }
        .form-signin .btn-primary:hover {
            background: #386fd3;
        }
        .form-signin img {
            border-radius: 50%;
        }
        .form-signin .form-label-group {
            margin-bottom: 15px;
        }
        .alert {
            position: absolute;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            max-width: 360px;
            width: 100%;
        }
    </style>
</head>
<body>
    <?php if(isset($_GET['error'])): ?>
        <div class="alert alert-danger text-center" role="alert">
            Username atau password salah!
        </div>
    <?php endif; ?>

    <form class="form-signin" method="POST" action="cek_loginP.php">
        <div class="text-center mb-4">
            <img class="mb-4" src="img/Blue_and_Black_Modern_Medical_Technology_Logo-removebg-preview.png" alt="Medilink Logo" width="200">
            
        
        </div>

        <div class="form-label-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" class="form-control" placeholder="Masukkan Username" required autofocus>
        </div>

        <div class="form-label-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan Password" required>
        </div>

        <div class="form-check mb-3">
            <input type="checkbox" class="form-check-input" id="rememberMe" value="remember-me">
            <label class="form-check-label" for="rememberMe">Remember me</label>
        </div>

        <button class="btn btn-lg btn-primary btn-block w-100" type="submit">Sign in</button>
        <p class="mt-3 text-center">Belum punya akun? <a href="registerP.php" class="text-primary">Daftar di sini</a></p>
        <p class="mt-1 mb-3 text-center text-muted">&copy; 2024 Medilink</p>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>