<?php
session_start();
include 'koneksi.php';
?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.101.0">
    <title>MEDILINK LOGIN</title>
<link rel="canonical" href="https://getbootstrap.com/docs/4.6/examples/floating-labels/">



<!-- Bootstrap core CSS -->
<link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">
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
  
  .bd-placeholder-img {
    font-size: 1.125rem;
    text-anchor: middle;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
  }

  @media (min-width: 768px) {
    .bd-placeholder-img-lg {
      font-size: 3.5rem;
    }
  }
</style>


<!-- Custom styles for this template -->
<link href="assets/dist/css/floating-labels.css" rel="stylesheet">
  </head>
  <body>
    <!-- Tambahkan ini di bagian atas form -->
<?php if(isset($_GET['error'])): ?>
    <div class="alert alert-danger">
        Username atau password salah!
    </div>
<?php endif; ?>
<form class="form-signin" method="POST" action="cek_loginAdmin.php">
  <div class="text-center mb-4">
    <img class="mb-4" src="img/Blue_and_Black_Modern_Medical_Technology_Logo-removebg-preview.png" alt="" width="400">
    
  
  </div>
  <div class="form-label-group">
    <input type="text" class="form-control" placeholder="Masukkan Username" name="username" required autofocus>
    <label>Masukkan Username</label>
  </div>
  <div class="form-label-group">
    <input type="password" name="password" class="form-control" placeholder="Masukkan Password" required>
    <label>Masukkan Password</label>
  </div>
  <div class="checkbox mb-3">
    <label>
      <input type="checkbox" value="remember-me"> Remember me
    </label>
  </div>
  <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
  <p class="mt-3 text-muted text-center">Belum punya akun? <a href="registerA.php">Daftar di sini</a></p>
  <p class="mt-1 mb-3 text-muted text-center">&copy;2024</p>
</form>
  </body>
</html>