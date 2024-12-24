<?php
session_start();
require_once 'koneksi.php';

if (!isset($_SESSION['id_pengguna'])) {
    header("Location: loginP.php");
    exit();
}

// Ambil data pesanan berdasarkan user yang login
$id_pengguna = $_SESSION['id_pengguna'];
$query = "SELECT * FROM pesanan WHERE id_pengguna = ? ORDER BY tanggal_pesanan DESC";
$stmt = mysqli_prepare($koneksi, $query);
mysqli_stmt_bind_param($stmt, "i", $id_pengguna);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$pesanan = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemantauan Pesanan</title>
    <!-- Link ke Bootstrap CSS dan Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <style>
        /* Kontainer untuk loading */
        .loading-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
            text-align: center;
            display: none; /* Disembunyikan pada awalnya */
        }

        /* Tampilan progress bar */
        .progress-container {
            width: 80%;
            background-color: #f3f3f3;
            border-radius: 20px;
            margin: 20px 0;
            height: 30px;
            position: relative;
        }

        /* Bagian progress yang bergerak */
        .progress-bar {
            height: 100%;
            width: 0%; /* Dimulai dari 0% */
            background-color: #28a745;
            border-radius: 20px;
            position: absolute;
            transition: width 3s linear; /* Durasi animasi 3 detik */
        }

        /* Pesan Loading */
        .loading-message {
            font-size: 1.2rem;
            margin-top: 10px;
        }

        /* Indikator animasi */
        .loader {
            margin-top: 20px;
            font-size: 1.5rem;
            font-weight: bold;
        }

        /* Card untuk pesanan */
        .card-body {
            padding: 1.5rem;
        }

        .card-title {
            font-size: 1.2rem;
        }

        .badge {
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Daftar Pesanan Anda</h2>
        <div class="row">
            <?php foreach ($pesanan as $p): ?>
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">No Pesanan: <?= $p['no_pesanan'] ?></h5>
                        <p class="card-text">Tanggal: <?= date('d/m/Y H:i', strtotime($p['tanggal_pesanan'])) ?></p>
                        <p class="card-text">Total Pembayaran: Rp <?= number_format($p['total_pembayaran'], 0, ',', '.') ?></p>
                        <p>
                            <span class="badge 
                                <?php 
                                    echo match($p['status']) {
                                        'pending' => 'bg-warning text-dark',
                                        'diproses' => 'bg-info text-white',
                                        'dikirim' => 'bg-primary text-white',
                                        'selesai' => 'bg-success text-white',
                                        default => 'bg-secondary text-white'
                                    };
                                ?>">
                                <i class="fas fa-circle"></i> <?= ucfirst($p['status']) ?>
                            </span>
                        </p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <!-- Loading section -->
    <div class="loading-container" id="loading-container">
        <h2>Proses : Driver ke Apotek</h2>
        <div class="progress-container">
            <div class="progress-bar" id="progress-bar"></div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>

</body>
</html>
