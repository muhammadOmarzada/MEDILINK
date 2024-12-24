<?php 
session_start();
require_once 'koneksi.php';

// Redirect ke login jika sesi pengguna belum login
if (!isset($_SESSION['id_pengguna'])) {
    header("Location: loginP.php");
    exit();
}

// Ambil ID pengguna dari query string
$id_pengguna = $_GET['id_pengguna'] ?? null;

// Validasi ID pengguna
if (!$id_pengguna || !is_numeric($id_pengguna)) {
    header("Location: users.php");
    exit();
}

// Query untuk mendapatkan detail pengguna
$sql = $koneksi->query("SELECT * FROM pengguna WHERE id_pengguna = $id_pengguna");

if ($sql && $sql->num_rows > 0) {
    $row = $sql->fetch_assoc();
} else {
    header("Location: users.php");
    exit();
}

function image_check($image, $folder = '', $default = 'default.png') {
    $path = "uploads/$image";
    return file_exists($path) ? $path : "uploads/$default";
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <!-- Menambahkan Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link
  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
  rel="stylesheet"
  >
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="chat.css">
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
    <div class="wrapper">
        <section class="chat-area">
            <header class="d-flex align-items-center">
                <!-- Tombol kembali dengan icon Bootstrap -->
                <a href="users.php" class="btn btn-light me-2"><i class="bi bi-arrow-left-circle"></i></a>
                <img src="<?= isset($row['img_path']) ? $row['img_path'] : 'default.jpg' ?>" alt="" class="rounded-circle" style="width: 50px; height: 50px;">
                <div class="details ms-3">
                    <span class="fw-bold"><?= htmlspecialchars($row['nama_lengkap']) ?></span>
                    <p class="text-muted"><?= htmlspecialchars($row['status']) ?></p>
                </div>
            </header>
            <div class="chat-box"></div>
            <form action="insert-chat.php" method="POST" class="typing-area d-flex">
                <input type="hidden" name="incoming_id" value="<?= htmlspecialchars($id_pengguna) ?>">
                <input type="text" name="message" class="form-control me-2" placeholder="Type a message here..." autocomplete="off">
                <button type="submit" class="btn btn-primary">
                <i class="bi bi-send"></i><i class="bi "></i>
                </button>
            </form>
        </section>
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


    <!-- Menambahkan Bootstrap JS dan ikon -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gybORlCbeChXSA8fD6q40A2y4b5XM58gYx3X9V3a8u7X9nM+dy" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0v8Fq9yXoYtWvTyjVVO9+WEXhf5kTH6smX1jOP0mO7qT24gk" crossorigin="anonymous"></script>
    <!-- Menambahkan FontAwesome untuk ikon jika perlu -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="chat.js"></script>
</body>
</html>
