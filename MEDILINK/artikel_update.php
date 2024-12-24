<?php
include "koneksi.php";

function input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Check if form is submitted
if (isset($_POST['update'])) {
    $id_artikel = htmlspecialchars($_POST["id_artikel"]);
    $judulartikel = htmlspecialchars($_POST["judulartikel"]);
    $penulisartikel = htmlspecialchars($_POST["penulisartikel"]);
    $isiartikel = htmlspecialchars($_POST["isiartikel"]);
    $tanggal = htmlspecialchars($_POST["tanggal"]);
    $kategori = htmlspecialchars($_POST["kategori"]);

    $sql = "UPDATE artikel SET 
            judulartikel='$judulartikel',
            penulisartikel='$penulisartikel',
            isiartikel='$isiartikel',
            tanggal='$tanggal',
            kategori='$kategori'
            WHERE id_artikel='$id_artikel'";

    $hasil = mysqli_query($koneksi, $sql);

    if ($hasil) {
        header("Location: artikel_index.php");
        exit();
    } else {
        echo "<div class='alert alert-danger'>Data Gagal diupdate.</div>";
    }
}

// Inisialisasi variabel untuk query gambar
$query_gambar = "";
    
// Cek apakah ada file baru yang diupload
if(isset($_FILES['img_path']) && $_FILES['img_path']['error'] == 0) {
    $allowed = array('jpg', 'jpeg', 'png');
    $filename = $_FILES['img_path']['name'];
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    
    // Validasi ekstensi file
    if(!in_array(strtolower($ext), $allowed)) {
        echo "<div class='alert alert-danger'>Format file tidak diizinkan. Harap upload file JPG, JPEG, atau PNG.</div>";
        exit;
    }
    
    // Validasi ukuran file (maksimal 2MB)
    if($_FILES['img_path']['size'] > 2097152) {
        echo "<div class='alert alert-danger'>Ukuran file terlalu besar. Maksimal 2MB.</div>";
        exit;
    }
    
    // Generate nama file unik
    $nama_file = time() . '_' . $filename;
    $target_dir = "uploads/";
    
    // Buat direktori jika belum ada
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    
    // Pindahkan file
    $upload_path = $target_dir . $nama_file;
    if(move_uploaded_file($_FILES['img_path']['tmp_name'], $upload_path)) {
        // Hapus file lama jika ada
        if(!empty($data['img_path']) && file_exists("uploads/" . $data['img_path'])) {
            unlink("uploads/" . $data['img_path']);
        }
        $query_gambar = ", img_path='$nama_file'";
    } else {
        echo "<div class='alert alert-danger'>Gagal mengupload file.</div>";
        exit;
    }
}

// Get article data
$id_artikel = htmlspecialchars($_GET["id_artikel"]);
$sql = "SELECT * FROM artikel WHERE id_artikel='$id_artikel'";
$hasil = mysqli_query($koneksi, $sql);
$data = mysqli_fetch_assoc($hasil);
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Update Artikel - Medilink</title>
    <style>
        #sidebar-wrapper {
            min-height: 100vh;
            margin-left: -15rem;
            transition: margin .25s ease-out;
        }

        #sidebar-wrapper .sidebar-heading {
            padding: 0.875rem 1.25rem;
            font-size: 1.2rem;
        }

        #sidebar-wrapper .list-group {
            width: 15rem;
        }

        #page-content-wrapper {
            min-width: 100vw;
        }

        #wrapper.toggled #sidebar-wrapper {
            margin-left: 0;
        }

        .list-group-item {
            border: none;
            padding: 1rem 1.25rem;
        }

        .list-group-item.active {
            background-color: #007bff;
            border-color: #007bff;
        }

        .list-group-item i {
            margin-right: 0.5rem;
        }

        @media (min-width: 768px) {
            #sidebar-wrapper {
                margin-left: 0;
            }

            #page-content-wrapper {
                min-width: 0;
                width: 100%;
            }

            #wrapper.toggled #sidebar-wrapper {
                margin-left: -15rem;
            }
        }

        .sidebar-divider {
            border-top: 1px solid rgba(255, 255, 255, 0.15);
            margin: 0 1rem 1rem;
        }
    </style>
</head>
<body>

<div class="d-flex" id="wrapper">
    <!-- Sidebar -->
    <div class="bg-dark text-white" id="sidebar-wrapper">
        <div class="sidebar-heading">Medilink</div>
        <div class="sidebar-divider"></div>
        <div class="list-group list-group-flush">
            <a href="index_admin.php" class="list-group-item list-group-item-action bg-dark text-white">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
            <a href="obat_index.php" class="list-group-item list-group-item-action bg-dark text-white">
                <i class="fas fa-pills"></i> Data Obat
            </a>
            <a href="artikel_index.php" class="list-group-item list-group-item-action bg-dark text-white active">
                <i class="fas fa-newspaper"></i> Artikel
            </a>
            <div class="sidebar-divider"></div>
            <a href="settings.php" class="list-group-item list-group-item-action bg-dark text-white">
                <i class="fas fa-cog"></i> Settings
            </a>
            <a href="logout.php" class="list-group-item list-group-item-action bg-dark text-white">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </div>

    <!-- Page Content -->
    <div id="page-content-wrapper">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <button class="btn btn-outline-light" id="menu-toggle">
                <i class="fas fa-bars"></i>
            </button>
        </nav>

        <!-- Main Content -->
        <div class="container-fluid">
            <h4 class="mt-4">Update Artikel</h4>
            <form action="" method="POST">
                <input type="hidden" name="id_artikel" value="<?php echo $data['id_artikel']; ?>">
                
                <div class="form-group">
                    <label>Judul Artikel:</label>
                    <input type="text" name="judulartikel" class="form-control" value="<?php echo $data['judulartikel']; ?>" required>
                </div>

                <div class="form-group">
                    <label>Penulis Artikel:</label>
                    <input type="text" name="penulisartikel" class="form-control" value="<?php echo $data['penulisartikel']; ?>" required>
                </div>

                <div class="form-group">
                    <label>Isi Artikel:</label>
                    <textarea name="isiartikel" class="form-control" rows="5" required><?php echo $data['isiartikel']; ?></textarea>
                </div>

                <div class="form-group">
                    <label>Tanggal:</label>
                    <input type="date" name="tanggal" class="form-control" value="<?php echo $data['tanggal']; ?>" required>
                </div>
                <div class="form-group">
        <label>Gambar Saat Ini:</label>
        <?php if(!empty($data['img_path']) && file_exists("uploads/" . $data['img_path'])): ?>
            <div class="mb-2">
                <img src="uploads/<?php echo $data['img_path']; ?>" alt="Gambar Artikel" class="img-thumbnail" style="max-width: 200px">
            </div>
        <?php else: ?>
            <p class="text-muted">Tidak ada gambar</p>
        <?php endif; ?>
        <label for="gambar">Upload Gambar Baru:</label>
        <input type="file" class="form-control" id="gambar" name="img_path" accept="image/*">
        <small class="form-text text-muted">Format yang diizinkan: JPG, JPEG, PNG. Maksimal 2MB</small>
    </div>
                <div class="form-group">
                    <label>Kategori:</label>
                    <select name="kategori" class="form-control" required>
                        <option value="Kesehatan" <?php if($data['kategori'] == 'Kesehatan') echo 'selected'; ?>>Mental</option>
                        <option value="Gaya Hidup" <?php if($data['kategori'] == 'Gaya Hidup') echo 'selected'; ?>>Gaya Hidup</option>
                        <option value="Obat" <?php if($data['kategori'] == 'Obat') echo 'selected'; ?>>Obat</option>
                        <option value="Tips" <?php if($data['kategori'] == 'Tips') echo 'selected'; ?>>Makanan</option>
                    </select>
                </div>

                <button type="submit" name="update" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update
                </button>
                <a href="artikel_index.php" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
<script>
$("#menu-toggle").click(function(e) {
    e.preventDefault();
    $("#wrapper").toggleClass("toggled");
});
</script>

</body>
</html>