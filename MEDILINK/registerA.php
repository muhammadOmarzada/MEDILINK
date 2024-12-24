<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.101.0">
    <title>DAFTAR DI SINI</title>
<link rel="canonical" href="https://getbootstrap.com/docs/4.6/examples/floating-labels/">



<!-- Bootstrap core CSS -->
<link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
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
<form class="form-signin" method="POST" action="cek_registerA.php">
  <div class="text-center mb-4">
    <img class="mb-4" src="medilink.png" alt="" width="72" height="72">
    <h1 class="h3 mb-3 font-weight-normal">FORM REGISTRASI</h1>
    <p>Masukkan Username dan Password</p>
  </div>
  <div class="form-label-group">
    <input type="email" class="form-control" placeholder="Masukkan Email" name="email" required autofocus>
    <label>Masukkan Email</label>
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
  <button class="btn btn-lg btn-primary btn-block" type="submit">Register</button>
  <p class="mt-3 text-muted text-center">Sudah punya akun? <a href="loginAdmin.php">Login di sini</a></p>
  <p class="mt-1 mb-3 text-muted text-center">&copy;2024</p>
</form>
  </body>
</html>