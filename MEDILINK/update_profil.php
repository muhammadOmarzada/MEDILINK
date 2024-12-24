<?php
session_start();
include "koneksi.php";

// Cek apakah user sudah login
if (!isset($_SESSION['id_pengguna'])) {
    header("Location: login.php");
    exit;
}

$id_pengguna = $_SESSION['id_pengguna'];

// Ambil data user
$query = "SELECT * FROM pengguna WHERE id_pengguna = '$id_pengguna'";
$result = mysqli_query($koneksi, $query);
$user = mysqli_fetch_array($result);

// Proses update profil
if(isset($_POST['submit'])) {
    $username = $_POST['username'];
    $nama_lengkap = $_POST['nama_lengkap'];
    header("Location: profil.php");
    // Inisialisasi update_query dengan versi tanpa gambar
    $update_query = "UPDATE pengguna SET 
                    username = '$username',
                    nama_lengkap = '$nama_lengkap'
                    WHERE id_pengguna = '$id_pengguna'";
    
    // Upload gambar jika ada
    if(isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
        // Buat folder uploads jika belum ada
        if (!file_exists('uploads')) {
            mkdir('uploads', 0777, true);
        }
        
        $target_dir = "uploads/";
        $file_extension = pathinfo($_FILES["profile_image"]["name"], PATHINFO_EXTENSION);
        $file_name = $id_pengguna . "_" . time() . "." . $file_extension;
        $target_file = $target_dir . $file_name;
        
        if(move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file)) {
            // Update query dengan path gambar jika upload berhasil
            $update_query = "UPDATE pengguna SET 
                           username = '$username',
                           nama_lengkap = '$nama_lengkap',
                           img_path = '$target_file'
                           WHERE id_pengguna = '$id_pengguna'";
        } else {
            echo "<div class='alert alert-danger'>Gagal mengupload file</div>";
        }
    }
    
    // Eksekusi query update
    if(mysqli_query($koneksi, $update_query)) {
        echo "<div class='alert alert-success'>Profil berhasil diupdate</div>";
        // Refresh halaman setelah 2 detik
        echo "<meta http-equiv='refresh' content='2'>";
    } else {
        echo "<div class='alert alert-danger'>Gagal mengupdate profil: " . mysqli_error($koneksi) . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MediLink - Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <!-- Navigasi -->
    <nav
  class="navbar navbar-expand-lg navbar-dark"
  style="background-color: #386fd3
"
>
  <div class="container d-flex align-items-center">
    <!-- Logo dan Nama -->
    <a class="navbar-brand" href="#">
      <img
        src="img/Blue and Black Modern Medical Technology Logo.png"
        style="height: 50px"
        class="rounded-5"
        alt=""
      />
    </a>

    <!-- Tombol Toggler untuk Menu di Kanan -->
    <button
      class="navbar-toggler"
      type="button"
      data-bs-toggle="collapse"
      data-bs-target="#navbarNav"
      aria-controls="navbarNav"
      aria-expanded="false"
      aria-label="Toggle navigation"
    >
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Menu Navigasi -->
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link navhov" href="indexPengguna.php">Beranda</a>
        </li>
        <li class="nav-item">
          <a class="nav-link navhov" href="menu_artikel.php">Artikel</a>
        </li>
        <li class="nav-item">
          <a class="nav-link navhov" href="profil.php">Profil</a>
        </li>
      </ul>
    </div>
  </div>
</nav>


    <div class="container mt-5">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <img src="<?php echo !empty($user['img_path']) ? $user['img_path'] : 'default-profile.jpg'; ?>" 
                             class="rounded-circle mb-3" 
                             style="width: 150px; height: 150px; object-fit: cover;">
                        <h5><?php echo htmlspecialchars($user['username']); ?></h5>
                        <p><?php echo htmlspecialchars($user['nama_lengkap']); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Edit Profil</h5>
                        <form method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label class="form-label">Username</label>
                                <input type="text" class="form-control" name="username" 
                                       value="<?php echo htmlspecialchars($user['username']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" name="nama_lengkap" 
                                       value="<?php echo htmlspecialchars($user['nama_lengkap']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Foto Profil</label>
                                <input type="file" class="form-control" name="profile_image" accept="image/*">
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>