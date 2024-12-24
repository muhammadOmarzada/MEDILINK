<?php
session_start();
require_once 'koneksi.php';

if(!isset($_SESSION['id_pengguna'])) {
    header("Location: loginP.php");
    exit();
}

if (!isset($_SESSION['session_id'])) {
    $_SESSION['session_id'] = session_id();
}

try {
    // Ambil data obat
    $result = mysqli_query($koneksi, "SELECT * FROM obat");
    $obat = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // Ambil data keranjang
    $stmt = mysqli_prepare($koneksi, "
        SELECT k.*, o.nama_obat, o.harga, o.img_path
        FROM keranjang k 
        JOIN obat o ON k.produk_id = o.id_obat 
        WHERE k.session_id = ?
    ");
    mysqli_stmt_bind_param($stmt, "s", $_SESSION['session_id']);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $cart_items = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // Hitung total keranjang
    $total_cart = 0;
    foreach ($cart_items as $item) {
        $total_cart += $item['harga'] * $item['jumlah'];
    }
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apotek Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link
  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
  rel="stylesheet"
  >
    <style>
        body {
           /* Sesuaikan dengan tinggi navbar */
        }
        .product-card {
            transition: transform 0.2s;
        }
        .product-card:hover {
            transform: translateY(-5px);
            border: 2px solid #007bff;
        }
        .product-image {
            height: 200px;
            object-fit: cover;
        }
        .cart-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
        }
    </style>
</head>
<body>
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
        <?php if (session_id()): ?>
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

    <div class="container py-5">
        <h2 class="text-center mb-4">Daftar Obat</h2>
        <div class="row">
            <?php foreach ($obat as $item): ?>
            <div class="col-md-3 mb-4">
                <div class="card product-card h-100">
                    <div class="card-body">
                        <img src="<?php echo "uploads/" . htmlspecialchars($item['img_path']) ?>" class="card-img-top" alt="...">
                        <h5 class="card-title"><?php echo htmlspecialchars($item['nama_obat']); ?></h5>
                        <p class="card-text">Jenis: <?php echo htmlspecialchars($item['jenis_obat']); ?></p>
                        <p class="card-text">Stok: <?php echo htmlspecialchars($item['stok']); ?></p>
                        <p class="card-text"><?php echo htmlspecialchars($item['deskripsi']); ?></p>
                        <p class="card-text fw-bold">Rp <?php echo number_format($item['harga'], 0, ',', '.'); ?></p>
                        <form action="add_to_cart.php" method="POST">
                            <input type="hidden" name="id_obat" value="<?php echo $item['id_obat']; ?>">
                            <div class="d-flex gap-2">
                                <input type="number" name="quantity" value="1" min="1" max="<?php echo $item['stok']; ?>" class="form-control" style="width: 80px;">
                                <button type="submit" class="btn btn-primary flex-grow-1" <?php echo ($item['stok'] < 1) ? 'disabled' : ''; ?>>
                                    <?php echo ($item['stok'] < 1) ? 'Stok Habis' : 'Tambah'; ?>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <button type="button" class="btn btn-primary rounded-circle cart-button p-3" data-bs-toggle="modal" data-bs-target="#cartModal">
        <i class="bi bi-cart-fill fs-4"></i>
        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
            <?php echo count($cart_items); ?>
        </span>
    </button>

    <div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cartModalLabel">Keranjang Belanja</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php if (empty($cart_items)): ?>
                        <p class="text-center">Keranjang belanja kosong</p>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Produk</th>
                                        <th>Nama</th>
                                        <th>Jumlah</th>
                                        <th>Harga</th>
                                        <th>Total</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($cart_items as $item): ?>
                                        <tr>
                                            <td>
                                                <img src="uploads/<?php echo htmlspecialchars($item['img_path']); ?>" 
                                                     alt="<?php echo htmlspecialchars($item['nama_obat']); ?>" 
                                                     style="width: 50px; height: 50px; object-fit: cover;">
                                            </td>
                                            <td><?php echo htmlspecialchars($item['nama_obat']); ?></td>
                                            <td>
                                                <input type="number" 
                                                       class="form-control form-control-sm" 
                                                       style="width: 70px"
                                                       value="<?php echo $item['jumlah']; ?>"
                                                       min="1"
                                                       onchange="updateQuantity(<?php echo $item['id']; ?>, this.value)">
                                            </td>
                                            <td>Rp <?php echo number_format($item['harga'], 0, ',', '.'); ?></td>
                                            <td>Rp <?php echo number_format($item['harga'] * $item['jumlah'], 0, ',', '.'); ?></td>
                                            <td>
                                                <button class="btn btn-danger btn-sm" onclick="removeItem(<?php echo $item['id']; ?>)">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4" class="text-end fw-bold">Total:</td>
                                        <td colspan="2" class="fw-bold">Rp <?php echo number_format($total_cart, 0, ',', '.'); ?></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <?php if (!empty($cart_items)): ?>
                        <button type="button" class="btn btn-primary" onclick="checkout()">Checkout</button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function checkout() {
            if (confirm('Apakah Anda yakin ingin checkout?')) {
                window.location.href = 'checkout.php';
            }
        }
    </script>
</body>
</html>
