<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>DAFTAR DI SINI</title>
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
    <form class="form-signin" method="POST" action="cek_registerP.php">
        <div class="text-center mb-4">
            <img class="mb-4" src="img/Blue_and_Black_Modern_Medical_Technology_Logo-removebg-preview.png" alt="" width="300">
            <h1 class="h3 mb-3 font-weight-normal">FORM REGISTRASI</h1>
            <p class="text-muted">Masukkan Username dan Password</p>
        </div>

        <div class="form-label-group">
        <label>Nama Lengkap</label>
            <input type="text" class="form-control" placeholder="Masukkan Nama Lengkap" name="nama_lengkap" required autofocus>
        </div>

        <div class="form-label-group">
        <label>Username</label>
            <input type="text" class="form-control" placeholder="Masukkan Username" name="username" required>
        </div>

        <div class="form-label-group">
        <label>Password</label>
            <input type="password" class="form-control" placeholder="Masukkan Password" name="password" required>
        </div>

        <div class="file-input-container">
    <label class="file-label">Upload File</label>
    <input type="file" class="custom-file-input" id="formFile" name="file" accept=".jpg,.png,.pdf,.docx">
</div>
        <div class="checkbox mb-3">
            <label>
                <input type="checkbox" value="remember-me"> Remember me
            </label>
        </div>

        <button class="btn btn-lg btn-primary btn-block" type="submit">Register</button>
        
        <p class="mt-3 text-muted text-center">Sudah punya akun? <a href="loginP.php">Login di sini</a></p>
        <p class="mt-1 mb-3 text-muted text-center">&copy;2024</p>
    </form>
</body>
</html>