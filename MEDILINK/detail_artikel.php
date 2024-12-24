<?php
include "koneksi.php";

// Ambil slug dari URL
$slug = isset($_GET['slug']) ? $_GET['slug'] : '';

if (empty($slug)) {
    die("Artikel tidak ditemukan");
}

// Query untuk mengambil detail artikel tanpa join ke tabel admin
$sql = "SELECT * FROM artikel WHERE slug = ?";

$stmt = $koneksi->prepare($sql);
$stmt->bind_param("s", $slug);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Artikel tidak ditemukan");
}

$artikel = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($artikel['judulartikel']); ?> - MediLink</title>
    <link
  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
  rel="stylesheet"
>
  
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="styleindex.css" />
</head>
<body>
    <!-- Navigasi -->
    <nav
  class="navbar navbar-expand-lg navbar-dark"
  style="background: linear-gradient(90deg, #386fd3, rgb(50, 149, 255))
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

    <!-- Header -->
    <header class="header-bg py-5" style="background: linear-gradient(90deg, #386fd3, rgb(50, 149, 255)); margin-top: 50px;">
        <div class="container">
            <h1 class="display-4 text-white"><?php echo htmlspecialchars($artikel['judulartikel']); ?></h1>
        </div>
    </header>

    <!-- Konten Artikel -->
    <div class="container my-5">
        <div class="row">
            <div class="col-lg-8">
                <!-- Gambar Artikel -->
                <?php if (!empty($artikel['img_path'])): ?>
                <img src="<?php echo htmlspecialchars($artikel['img_path']); ?>" 
                     class="img-fluid rounded mb-4" 
                     alt="<?php echo htmlspecialchars($artikel['judulartikel']); ?>">
                <?php endif; ?>

                <!-- Meta Informasi -->
                <div class="mb-4">
                    <p class="text-muted">
                        <strong>Penulis:</strong> <?php echo htmlspecialchars($artikel['penulisartikel']); ?><br>
                        <strong>Kategori:</strong> <?php echo htmlspecialchars($artikel['kategori']); ?><br>
                        <strong>Tanggal:</strong> <?php echo date('d F Y', strtotime($artikel['tanggal'])); ?>
                    </p>
                </div>

                <!-- Isi Artikel -->
                <div class="article-content">
                    <?php echo nl2br(htmlspecialchars($artikel['isiartikel'])); ?>
                </div>
            </div>
        </div>

        <!-- Tombol Kembali -->
        <div class="mt-5">
            <a href="menu_artikel.php" class="btn btn-primary">Kembali ke Daftar Artikel</a>
        </div>
    </div>

        <!-- Footer -->
        <footer class="text-white text-center py-5" style="background: linear-gradient(90deg, #386fd3, rgb(50, 149, 255))">
  <!-- Bagian Tautan Sosial Media -->
  <div class="footer-top">
  <a data-mdb-ripple-init class="btn btn-primary" style="background-color: #25d366;" href="#!" role="button">
    <i class="fab fa-whatsapp"></i>
  </a>
  <a data-mdb-ripple-init class="btn btn-primary" style="background-color: #3b5998;" href="#!" role="button">
    <i class="fab fa-facebook-f"></i>
  </a>
  <a data-mdb-ripple-init class="btn btn-primary" style="background-color: #ac2bac;" href="#!" role="button">
    <i class="fab fa-instagram"></i>
  </a>
  <a data-mdb-ripple-init class="btn btn-primary" style="background-color: #ed302f;" href="#!" role="button">
    <i class="fab fa-youtube"></i>
  </a>
</div>

<style>
.footer-top a {
  display: inline-block;
  transition: all 0.3s ease;
}

.footer-top a:hover {
  padding-left: 25px ;
  padding-right: 25px ;
  transform: scale(1.2);
}
</style>


  <!-- Bagian Hak Cipta -->
  <div class="footer-bottom py-5">
    <p>&copy; 2023 Pawang Kesehatan. Hak Cipta Dilindungi.</p>
  </div>
</footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>