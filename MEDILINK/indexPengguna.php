<?php
// Pastikan session sudah dimulai
session_start();

// Menyertakan koneksi database
include "koneksi.php";

// Mengambil ID pengguna dari session (tetap ada)
$id_pengguna = isset($_SESSION['id_pengguna']) ? $_SESSION['id_pengguna'] : null;

// Menampilkan artikel meskipun tidak ada pengguna yang login
$query_artikel = "SELECT * FROM artikel";
$result_artikel = mysqli_query($koneksi, $query_artikel);

// Jika ada pengguna yang login, ambil data pengguna
if ($id_pengguna) {
    $query_user = "SELECT username, nama_lengkap, img_path FROM pengguna WHERE id_pengguna = ?";
    $stmt_user = mysqli_prepare($koneksi, $query_user);
    mysqli_stmt_bind_param($stmt_user, "i", $id_pengguna);
    mysqli_stmt_execute($stmt_user);
    $result_user = mysqli_stmt_get_result($stmt_user);
    
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
    // Jika tidak ada pengguna yang login, set default values
    $username = ' ';
    $nama_lengkap = ' ';
    $img_path = 'default.png';
}

// Menyimpan artikel dalam array meskipun tidak ada pengguna yang login
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
  <body class="page-content">
    <!-- Navigasi -->
<nav class="navbar navbar-expand-lg navbar-dark" style="background: linear-gradient(90deg, #386fd3, rgb(50, 149, 255));
">
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

    <header
      id="beranda"
      class="header-bg py-5"
      style="background: linear-gradient(90deg, #386fd3,rgb(50, 149, 255));"
    >
      <div class="header-bg-overlay"></div>
      <div class="container ">
        <h1
          class="display-5 align-text-left mx-5 pt-1 "
          style="color: aliceblue; font-size: 5vh; font-family: Helvetica"
        >
          <br />
          <b >Selamat Datang <?php echo htmlspecialchars($username); ?> </b>
        </h1>
        <p
          class="lead mx-5 my-3"
          style="color: aliceblue; padding-top: 1vh; font-size: 3.5vh"
        >
          <b>Layanan Medis Secara Online, Tidak Perlu Ribet Antri Lagi</b>
        </p>
      </div>
    </header>

    <!-- Bagian Tentang Saya -->
    <section id="tentang" class="py-5">
    <style>
  /* Animasi untuk gambar */
  .img-fluid {
    opacity: 0;
    transform: translateY(50px);
    transition: opacity 1s ease-out, transform 1s ease-out;
  }

  .img-fluid.visible {
    opacity: 1;
    transform: translateY(0);
  }

  /* Animasi untuk teks */
  .col-md-6 p {
    opacity: 0;
    transform: translateX(-50px);
    transition: opacity 1s ease-out, transform 1s ease-out;
  }

  .col-md-6 p.visible {
    opacity: 1;
    transform: translateX(0);
  }

  /* Animasi ketika elemen muncul di viewport */
  .fade-in {
    opacity: 0;
    transform: translateY(50px);
    animation: fadeIn 1s ease-out forwards;
  }

  @keyframes fadeIn {
    0% {
      opacity: 0;
      transform: translateY(50px);
    }
    100% {
      opacity: 1;
      transform: translateY(0);
    }
  }
</style>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    const elements = document.querySelectorAll("#tentang .img-fluid, #tentang .col-md-6 p");

    function checkVisibility() {
      elements.forEach(element => {
        const rect = element.getBoundingClientRect();
        if (rect.top < window.innerHeight && rect.bottom >= 0) {
          element.classList.add("visible");
        }
      });
    }

    // Mengaktifkan deteksi visibilitas
    checkVisibility();
    window.addEventListener("scroll", checkVisibility);
  });
</script>

      <div class="container">
        <div class="row align-items-center">
          <div class="col-md-6">
            <img
              src="img/cheerful-male-doctor-with-tablet-pen.jpg"
              alt="Foto Saya"
              class="img-fluid rounded mb-1 mx-5"
              style="max-width: 55vh"
            />
          </div>
          <div class="col-md-6" style="padding-top: 150px">
            <p>
              Medilink - Partner Kesehatan Digital Anda Solusi kesehatan digital
              terpercaya yang menghubungkan Anda dengan layanan kesehatan
              berkualitas dalam genggaman. Medilink hadir untuk memudahkan akses
              kesehatan Anda kapan saja dan di mana saja.
            </p>
            <p>
              Konsultasi Online dengan Dokter Terpercaya Tidak perlu lagi
              menghabiskan waktu di ruang tunggu. Melalui Medilink, Anda dapat
              berkonsultasi langsung dengan dokter berpengalaman melalui chat
              atau video call. Tim dokter kami siap memberikan saran medis
              profesional, resep obat, dan rujukan bila diperlukan.
            </p>
            <p>
              Artikel Kesehatan Terkini Perkaya pengetahuan Anda tentang
              kesehatan melalui artikel-artikel berkualitas yang ditulis oleh
              tim medis profesional kami. Temukan informasi terpercaya seputar
              Tips menjaga kesehatan, Informasi penyakit dan pengobatan, Panduan
              gaya hidup sehat, dan Berita terkini seputar dunia kesehatan.
            </p>
          </div>
        </div>
      </div>
    </section>
    <hr />

    <!-- Menu -->
    <section id="menu" class="py-3">
      <div class="container menu">
        <h3 class="text-center">Layanan</h3>
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

    <script>
  document.addEventListener("DOMContentLoaded", function () {
    const navbar = document.querySelector(".navbar");
    
    window.addEventListener("scroll", function () {
      if (window.scrollY > 0) {
        navbar.classList.add("scrolled");
      } else {
        navbar.classList.remove("scrolled");
      }
    });
  });
</script>

    <!-- Footer -->
    <footer class="text-white text-center py-5" style="background: linear-gradient(90deg, #386fd3,rgb(50, 149, 255));">
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


    <!-- JavaScript Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
