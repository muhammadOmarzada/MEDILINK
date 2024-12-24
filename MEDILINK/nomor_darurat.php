<?php
// Memulai session
session_start();

// Menyertakan koneksi database
include "koneksi.php";

// Mengambil ID pengguna dari session
$id_pengguna = isset($_SESSION['id_pengguna']) ? $_SESSION['id_pengguna'] : null;

if ($id_pengguna) {
    // Query untuk data pengguna
    $query_user = "SELECT username, nama_lengkap, img_path FROM pengguna WHERE id_pengguna = ?";
    $stmt_user = mysqli_prepare($koneksi, $query_user);
    mysqli_stmt_bind_param($stmt_user, "i", $id_pengguna);
    mysqli_stmt_execute($stmt_user);
    $result_user = mysqli_stmt_get_result($stmt_user);

    // Query untuk data nomor darurat
    $query_noDarurat = "SELECT * FROM nomor_darurat ORDER BY nama_rs ASC";
    $result_noDarurat = mysqli_query($koneksi, $query_noDarurat);

    // Cek data pengguna
    if ($result_user && mysqli_num_rows($result_user) > 0) {
        $user = mysqli_fetch_assoc($result_user);
        $username = $user['username'];
        $nama_lengkap = $user['nama_lengkap'];
        $img_path = !empty($user['img_path']) ? $user['img_path'] : 'default.png';
    } else {
        $username = 'Nama Pengguna Tidak Ditemukan';
        $nama_lengkap = 'Nama Lengkap Tidak Ditemukan';
        $img_path = 'default.png';
    }
} else {
    $username = 'Pengguna Tidak Dikenal';
    $nama_lengkap = 'Pengguna Tidak Dikenal';
    $img_path = 'default.png';
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Nomor Darurat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="styleindex.css" />
    <style>
        body {
            padding-top: 50px;
        }
        .card {
            border: 2px solid transparent;
            transition: all 0.3s ease;
        }
        .card:hover {
            border: 2px solid #007bff;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transform: translateY(-5px);
        }
    </style>
</head>
<body>
    <!-- Navigasi -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" style="background-color: #ffff">
        <div class="container d-flex align-items-center">
            <!-- Logo dan Nama -->
            <a class="navbar-brand" href="#">
                <img src="img/Blue and Black Modern Medical Technology Logo.png" style="height: 50px" alt="Logo" />
            </a>

            <!-- Tombol Toggler untuk Menu di Kanan -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Menu Navigasi -->
            <div class="collapse navbar-collapse navigation" id="navbarNav" style="color: #386fd3">
                <ul class="navbar-nav ms-auto navigation">
                    <li class="nav-item">
                        <a class="nav-link" href="indexPengguna.php">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#menu">Layanan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="menu_artikel.php">Artikel</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="profil.php">Profil</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <header id="beranda" class="header-bg py-5" style="background-color: #386fd3">
        <div class="header-bg-overlay"></div>
        <div class="container">
            <h1 class="display-4 align-text-left mx-5" style="color: aliceblue; font-size: 5vh; font-family: Helvetica">
                <br />
                <b>Nomor Darurat</b>
            </h1>
            <p class="lead mx-5" style="color: aliceblue; padding-top: 1vh; font-size: 3.5vh">
                <b>Nomor Telefon yang Dapat Digunakan Untuk menghubungi Rumah Sakit</b>
            </p>
        </div>
    </header>

    <!-- Konten Nomor Darurat -->
    <section id="tentang" class="py-5">
        <div class="container">
            <div class="row">
                <?php 
                if ($result_noDarurat && mysqli_num_rows($result_noDarurat) > 0): 
                    while($row = mysqli_fetch_assoc($result_noDarurat)): 
                ?>
                    <div class="col-md-4 mb-4">
                        <div class="card card-hover h-100">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <span style="color:#386fd3"><?php echo htmlspecialchars($row['nama_rs']); ?></span></h5>
                                <p class="card-text">
                                    <span
                                    style="color: #386fd3;">
                                    <strong>Nomor Telepon:</strong><br>
                                    <?php echo htmlspecialchars($row['nomor_rs']); ?>
                                    </span>
                                </p>
                                <a href="tel:<?php echo htmlspecialchars($row['nomor_rs']); ?>" 
                                   class="btn"
                                   style="background-color: #386fd3;
                                   color:white">
                                    Hubungi Sekarang
                                </a>
                            </div>
                        </div>
                    </div>
                <?php 
                    endwhile;
                else: 
                ?>
                    <div class="col-12 text-center">
                        <p>Tidak ada nomor darurat yang tersedia saat ini.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="text-white text-center py-3" style="background-color: #386fd3; position: relative">
        <p>&copy; 2023 Pawang kesehatan. Hak Cipta Dilindungi.</p>
    </footer>

    <!-- JavaScript Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>