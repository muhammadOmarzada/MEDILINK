<?php
// Pastikan session sudah dimulai
session_start();

// Menyertakan koneksi database
include "koneksi.php";
if(!isset($_SESSION['id_pengguna'])) {
  header("Location: loginP.php");
  exit();
}
// Mengambil ID pengguna dari session
$id_pengguna = isset($_SESSION['id_pengguna']) ? $_SESSION['id_pengguna'] : null;

$query = "SELECT * FROM pesanan WHERE id_pengguna = ? ORDER BY tanggal_pesanan DESC";
$stmt = mysqli_prepare($koneksi, $query);
mysqli_stmt_bind_param($stmt, "i", $_SESSION['id_pengguna']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$pesanan = mysqli_fetch_all($result, MYSQLI_ASSOC);

if ($id_pengguna) {
  // Use prepared statement
  $query = "SELECT username, nama_lengkap, img_path FROM pengguna WHERE id_pengguna = ?";
  $stmt = mysqli_prepare($koneksi, $query);
  mysqli_stmt_bind_param($stmt, "i", $id_pengguna);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);

  // Cek jika data ditemukan
  if ($result && mysqli_num_rows($result) > 0) {
      $user = mysqli_fetch_assoc($result);
      $username = $user['username'];
      $nama_lengkap = $user['nama_lengkap'];
      $img_path = $user['img_path'];
  } else {
      $username = 'Nama Pengguna Tidak Ditemukan';
  }
} else {
  $username = 'Pengguna Tidak Dikenal';
  $nama_lengkap = 'Pengguna Tidak Dikenal';
}

?>
<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Welcome to MediLink!!</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link
  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
  rel="stylesheet"
  >
    <link rel="stylesheet" href="styleindex.css" />
    <style>
      body {
       
        background-color: #f4f4f4;
      }
   
    </style>
  </head>
  <body >
    <!-- Navigasi -->
    <nav
  class="navbar navbar-expand-lg navbar-dark"
  style="background: linear-gradient(90deg, #386fd3, rgb(50, 149, 255));
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

   
    <header
      id="beranda"
      class="header-bg py-5"
      style="background: linear-gradient(90deg, #386fd3, rgb(50, 149, 255));
"
    >
      <div class="header-bg-overlay"></div>
      <div class="container">
        <h1
          class="display-4 align-text-left mx-5"
          style="color: aliceblue; font-size: 5vh; font-family: Helvetica"
        >
          <br />
          <b>Profil </b>

        </h1>
        <p
          class="lead mx-5"
          style="color: aliceblue; padding-top: 1vh; font-size: 3.5vh"
        >
          <b>Ganti Profil disini</b>
        </p>
      </div>
    </header>

    <span class="border border-primary" style="border-color: red;">
    <div class="container">
        <div class="row py-5 px-5 mx-5">
            <div class="col-md-3 rounded-start-4" style="background-color:#386fd3"> 
                <div class="user-info rounded">
                    <img src="<?php echo htmlspecialchars($img_path) ?>" 
                         alt="<?php echo htmlspecialchars($img_path) ?>" 
                         style="max-width: 200px; max-height:200px;" 
                         class="mx-3 py-4">
                </div>
            </div>
            <div class="col-md-9 rounded-end-4 pt-4" style="background: linear-gradient(90deg, #386fd3, rgb(50, 149, 255));
"> 
                <div class="user-info">
                    <h3 style="color: white">Profil Pengguna</h3>
                    <p style="color: white"><strong>Username:</strong> <?php echo htmlspecialchars($username); ?></p>
                    <p style="color: white"><strong>Nama Lengkap:</strong> <?php echo htmlspecialchars($nama_lengkap); ?></p>
                    <p style="color: white"><strong>ID Pengguna:</strong> <?php echo htmlspecialchars($id_pengguna); ?></p>     
                </div>
                <div class="col-md-3 pb-4"> 
                    <button type="button" class="btn btn-light" >
                        <a href="update_profil.php" style="text-decoration: none; color: #386fd3;">Edit Profil</a>
                    </button>
                    <button type="button" class="btn btn-light" >
                        <a href="logoutP.php" style="text-decoration: none; color: #386fd3;">Logout</a>
                    </button>
                </div>
              
                
            </div>
        </div>
    </div>
</span>


    <!-- Menu -->
    <section id="menu" class="py-3">
      <div class="container menu">
        <h3 class="text-center">Akses Cepat</h3><br>
        <div class="row justify-content-center" style="">
          <div class="col-md-3">
            <a href="users.php">
              <div class="card text-center">
                <div class="image">
                  <img src="https://img.icons8.com/external-line512-zulfa-mahendra/64/386fd3/external-consultation-online-pharmacy-line512-zulfa-mahendra.png" width="36" />
                <!-- <img width="64" height="64" src="https://img.icons8.com/external-pseudo-solid-zulfa-mahendra/64/386fd3/external-consultation-online-pharmacy-pseudo-solid-zulfa-mahendra.png" alt="external-consultation-online-pharmacy-pseudo-solid-zulfa-mahendra"/> -->
                </div>
                <span>Konsultasi</span>
              </div>
            </a>
          </div>

          <div class="col-md-3">
            <a href="marketplace.php">
              <div class="card text-center">
                <div class="image">
                  <img src="img/icons8-pill-50.png" width="36" />
                </div>
                <span>Marketplace</span>
              </div>
            </a>
          </div>

          <div class="col-md-3">
            <a href="nomor_darurat.php">
              <div class="card text-center">
                <div class="image">
                  <img src="https://img.icons8.com/ios/50/386fd3/hospital-2.png" alt="hospital-2" width="36" />
                </div>
                <span>Nomor Darurat</span>
              </div>
            </a>
          </div>
        </div>
      </div>
    </section>

    <style>.card {
    border: 2px solid transparent;
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column; /* Memastikan card menjadi kolom */
    height: 100%; /* Memastikan card mengisi ruang di kolom */
}

.card-body {
    flex-grow: 1; /* Memastikan konten di dalam card tumbuh dan mengisi ruang */
}

.card:hover {
    border: 2px solid #007bff; /* Warna biru Bootstrap */
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    transform: translateY(-5px);
}

.card-title {
    font-size: 1.1rem;
    font-weight: bold;
}

.card-text {
    font-size: 0.9rem;
}

.card-body a {
    margin-top: auto; /* Menjaga tombol selalu di bagian bawah card */
}
</style>

<!-- Bagian Status Pesanan -->
<section class="py-4">
  <div class="container">
    <h3 class="text-center mb-4">Riwayat Pesanan</h3>
    <div class="row justify-content-center">
      <?php if (empty($pesanan)): ?>
        <div class="col-md-8 text-center">
          <div class="alert alert-info">
            Belum ada pesanan yang dibuat.
          </div>
        </div>
      <?php else: ?>
        <?php foreach ($pesanan as $p): ?>
          <div class="col-md-8 mb-3">
            <div class="card shadow-sm">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                  <div>
                    <h5 class="card-title mb-1">No. Pesanan: <?= htmlspecialchars($p['no_pesanan']) ?></h5>
                    <p class="card-text text-muted mb-2">
                      <small>Tanggal: <?= date('d/m/Y H:i', strtotime($p['tanggal_pesanan'])) ?></small>
                    </p>
                    <p class="card-text">
                      Total: Rp <?= number_format($p['total_pembayaran'], 0, ',', '.') ?>
                    </p>
                  </div>
                  <a href="monitor_pesanan.php?id_pesanan=<?= htmlspecialchars($p['id_pesanan']) ?>" 
                     class="btn btn-primary">
                    <i class="fas fa-eye me-1"></i> Lihat Detail
                  </a>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>
</section>

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


  
</script>

    <!-- JavaScript Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
