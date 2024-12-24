<?php 
session_start();
include "koneksi.php";

// Cek login dengan redirect dan exit
if (!isset($_SESSION['id_pengguna'])) {
    header("Location: loginP.php");
    exit();
}

// Ambil data pengguna
$id_pengguna = $_SESSION['id_pengguna'];
$sql = $koneksi->prepare("SELECT * FROM pengguna WHERE id_pengguna = ?");
$sql->bind_param("i", $id_pengguna);
$sql->execute();
$result = $sql->get_result();
$row = $result->fetch_assoc();

// Ambil daftar pengguna lain selain pengguna yang sedang login
$sql = $koneksi->prepare("SELECT * FROM pengguna WHERE id_pengguna != ?");
$sql->bind_param("i", $id_pengguna);
$sql->execute();
$result = $sql->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Users</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .wrapper {
            max-width: 400px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .users header {
            background: #007bff;
            color: #fff;
            padding: 20px;
            text-align: center;
        }

        .users header .content {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .users header img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
        }

        .users .search {
            padding: 10px 20px;
            border-bottom: 1px solid #f1f1f1;
        }

        .users .search input {
            width: calc(100% - 50px);
            border: none;
            border-radius: 20px;
            padding: 8px 15px;
            outline: none;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .users .search button {
            background: none;
            border: none;
            color: #007bff;
            font-size: 20px;
        }

        .users .users-list {
            max-height: 300px;
            overflow-y: auto;
            padding: 10px 20px;
        }

        .users .users-list .user {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 10px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .users .users-list .user:hover {
            background: #f1f1f1;
        }

        .users .users-list img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }

        .users .users-list .details {
            flex-grow: 1;
        }

        .users .users-list .details span {
            font-weight: 500;
        }

        .users .users-list .details p {
            margin: 0;
            font-size: 14px;
            color: #666;
        }
    </style>
</head>

<body>
    <!-- Navigasi -->
    <nav class="navbar navbar-expand-lg navbar-dark" style="background: linear-gradient(90deg, #386fd3, rgb(50, 149, 255))">
        <div class="container d-flex align-items-center">
            <a class="navbar-brand" href="#">
                <img src="img/Blue and Black Modern Medical Technology Logo.png" style="height: 50px" class="rounded-5" alt=""/>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link navhov" href="indexPengguna.php">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link navhov" href="#menu">Layanan</a></li>
                    <li class="nav-item"><a class="nav-link navhov" href="menu_artikel.php">Artikel</a></li>
                    <li class="nav-item"><a class="nav-link navhov" href="profil.php">Profil</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh">
        <div class="wrapper">
            <section class="users">
                <header>
                    <div class="content">
                        <img src="<?= isset($row['img_path']) ? $row['img_path'] : 'default.jpg' ?>" alt="">
                        <div class="details">
                            <span><?php echo htmlspecialchars($row['nama_lengkap']); ?></span>
                            <p><?php echo htmlspecialchars($row['status']); ?></p>
                        </div>
                    </div>
                </header>

                <div class="search">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Enter name to search...">
                        <button class="btn btn-outline-secondary"><i class="fas fa-search"></i></button>
                    </div>
                </div>

                <div class="users-list">
                    <?php while ($user = $result->fetch_assoc()) { ?>
                        <div class="user">
                            <img src="<?= isset($user['img_path']) ? $user['img_path'] : 'default.jpg' ?>" alt="">
                            <div class="details">
                                <span><?= htmlspecialchars($user['nama_lengkap']); ?></span>
                                <p><?= htmlspecialchars($user['status']); ?></p>
                            </div>
                            <!-- Tambahkan link ke chat.php dengan membawa id_pengguna -->
                            <a href="chat.php?id_pengguna=<?= $user['id_pengguna']; ?>" class="btn btn-link">Chat</a>
                        </div>
                    <?php } ?>
                </div>
            </section>
        </div>
    </div>
     <script src="<?= base_url('assets/dist/js/users.js') ?>"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
