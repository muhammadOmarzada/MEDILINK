<?php
// Pastikan session sudah dimulai
session_start();

// Menyertakan koneksi database
// Menyertakan koneksi database
include "koneksi.php";

// Mengambil ID pengguna dari session
$id_pengguna = isset($_SESSION['id_pengguna']) ? $_SESSION['id_pengguna'] : null;

// Mengambil data pengguna jika ada
if ($id_pengguna) {
    $query_user = "SELECT username, nama_lengkap, img_path FROM pengguna WHERE id_pengguna = ?";
    $stmt_user = mysqli_prepare($koneksi, $query_user);
    mysqli_stmt_bind_param($stmt_user, "i", $id_pengguna);
    mysqli_stmt_execute($stmt_user);
    $result_user = mysqli_stmt_get_result($stmt_user);

    if ($result_user && mysqli_num_rows($result_user) > 0) {
        $user = mysqli_fetch_assoc($result_user);
        $username = $user['username'];
        $nama_lengkap = $user['nama_lengkap'];
        $img_path = !empty($user['img_path']) ? $user['img_path'] : 'default.png';
    }
} else {
    $username = 'Nama Pengguna Tidak Ditemukan';
    $nama_lengkap = 'Nama Lengkap Tidak Ditemukan';
    $img_path = 'default.png';
}

// Selalu ambil artikel, tidak tergantung login
$query_artikel = "SELECT * FROM artikel";
$result_artikel = mysqli_query($koneksi, $query_artikel);

// Cek dan simpan artikel dalam array
$articles = array();
while ($row = mysqli_fetch_assoc($result_artikel)) {
    $articles[] = array(
        'judulartikel' => $row['judulartikel'],
        'penulisartikel' => $row['penulisartikel'],
        'isiartikel' => $row['isiartikel'],
        'tanggal' => $row['tanggal'],
        'kategori' => $row['kategori'],
        'img_path' => $row['img_path']
    );
}
?>

<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Welcome to MediLink!!</title>
    <link
  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
  rel="stylesheet"
>
  
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="styleindex.css" />
    <style>
      body {
        
      }
    </style>
  </head>
  <body>
    <!-- Navigasi -->
    <nav
  class="navbar navbar-expand-lg navbar-dark"
  style="background: linear-gradient(90deg, #386fd3,rgb(50, 149, 255));
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
        <?php if ($id_pengguna): ?>
          <!-- Menu untuk user yang sudah login -->
          <li class="nav-item">
            <a class="nav-link navhov" href="indexPengguna.php">Beranda</a>
          </li>
          <li class="nav-item">
            <a class="nav-link navhov" href="menu_artikel.php">Artikel</a>
          </li>
          <li class="nav-item">
            <a class="nav-link navhov" href="profil.php">Profil</a>
          </li>
        <?php else: ?>
          <!-- Menu untuk user yang belum login -->
          <li class="nav-item">
            <a class="nav-link navhov" href="indexPengguna.php">Beranda</a>
          </li>
          <li class="nav-item">
            <a class="nav-link navhov" href="menu_artikel.php">Artikel</a>
          </li>
          <li class="nav-item">
    <a class="btn btn-light navhov text-primary" id="log" href="loginP.php" style="margin-left: 10px;">Bergabung Dengan Kami</a>
</li>
<style>
  #log:hover {
      color: #ffffff; /* Ubah warna teks saat hover */
      background-color: #386fd3; /* Opsional: Ubah latar belakang saat hover */
      border-radius: 5px; /* Membuat sudut melengkung */
  }
</style>


          </style>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

    <!-- background-image: url(desain-rumah-sakit-uii-683x321.jpg);
   padding-bottom: 150px;  -->
    <header
      id="beranda"
      class="header-bg py-5"
      style="background: linear-gradient(90deg, #386fd3,rgb(50, 149, 255));"
    >
      <div class="header-bg-overlay"></div>
      <div class="container">
        <h1
          class="display-4 align-text-left mx-5"
          style="color: aliceblue; font-size: 5vh; font-family: Helvetica"
        >
          <br />
          <b>Artikel </b>

        </h1>
        <p
          class="lead mx-5"
          style="color: aliceblue; padding-top: 1vh; font-size: 3.5vh"
        >
          <b>Baca Artikel Kesehatan Dimana Saja dan Kapan Saja</b>
        </p>
      </div>
    </header>
    <!-- ... (bagian navigasi tetap sama) ... -->
    
    <!-- Bagian Artikel -->
    <section id="tentang" class="py-5">
    <div class="container">
    <h1 class="text-center" >Artikel</h1>

        <div class="row">
            <?php if (empty($articles)): ?>
                <div class="col-12">
                    <p>Tidak ada artikel yang tersedia.</p>
                </div>
            <?php else: ?>
                <?php 
                    // Query untuk mengambil semua artikel
                    $query = "SELECT * FROM artikel LIMIT 4";
                    $result = mysqli_query($koneksi, $query);
                    
                    while($row = mysqli_fetch_assoc($result)): 
                ?>
                    <div class="col-md-3 mb-4 d-flex"> <!-- Menambahkan d-flex disini -->
                        <div class="card card-hover h-100"> <!-- Menambahkan h-100 untuk menyesuaikan tinggi -->
                            <style>
                                .card {
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

                                /* Menyesuaikan gambar agar responsif */
                                .card-img {
                                    width: 100%; /* Membuat gambar lebar 100% */
                                    height: 200px; /* Menetapkan tinggi gambar */
                                    object-fit: cover; /* Agar gambar menyesuaikan dengan ukuran tanpa merusak proporsi */
                                }
                            </style>    
                            <div class="row py-0">
                                <div class="col-12">
                                    <img src="<?php echo htmlspecialchars($row['img_path']); ?>" 
                                         class="card-img rounded-3" alt="Gambar Artikel">
                                </div>
                                <div class="col-md-12">
                                    <div class="card-body d-flex flex-column"> <!-- Menggunakan flex-column di card-body -->
                                        <h5 class="card-title"><?php echo htmlspecialchars($row['judulartikel']); ?></h5>
                                        <p class="card-text">
                                            <small class="text-muted">
                                                Ditulis oleh: <?php echo htmlspecialchars($row['penulisartikel']); ?><br>
                                                Tanggal: <?php echo htmlspecialchars($row['tanggal']); ?><br>
                                                Kategori: <?php echo htmlspecialchars($row['kategori']); ?>
                                            </small>
                                        </p>
                                        <a href="detail_artikel.php?slug=<?php echo $row['slug']; ?>" class="btn btn-primary btn-sm mt-auto">
                                            Baca
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </div>
</section>
        

    
    
    <!-- JavaScript Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>