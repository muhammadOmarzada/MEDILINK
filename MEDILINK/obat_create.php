<?php
include "koneksi.php";

function input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_obat = input($_POST["nama_obat"]);
    $jenis_obat = input($_POST["jenis_obat"]);
    $stok = input($_POST["stok"]);
    $harga = input($_POST["harga"]);
    $deskripsi = input($_POST["deskripsi"]);
    $tanggal_ditambahkan = input($_POST["tanggal_ditambahkan"]);
    
    // Inisialisasi variabel untuk nama file
    $nama_file = "";
    
    // Cek apakah ada file yang diupload
    if(isset($_FILES['img_path']) && $_FILES['img_path']['error'] == 0) {
        $allowed = array('jpg', 'jpeg', 'png');
        $filename = $_FILES['img_path']['name'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        
        // Validasi ekstensi file
        if(!in_array(strtolower($ext), $allowed)) {
            echo "<div class='alert alert-danger mt-4'>Format file tidak diizinkan. Harap upload file JPG, JPEG, atau PNG.</div>";
            exit;
        }
        
        // Validasi ukuran file (maksimal 2MB)
        if($_FILES['img_path']['size'] > 2097152) {
            echo "<div class='alert alert-danger mt-4'>Ukuran file terlalu besar. Maksimal 2MB.</div>";
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
        if(!move_uploaded_file($_FILES['img_path']['tmp_name'], $upload_path)) {
            echo "<div class='alert alert-danger mt-4'>Gagal mengupload file.</div>";
            exit;
        }
    }

    // Query untuk memasukkan data ke tabel obat
    $sql = "INSERT INTO obat (nama_obat, jenis_obat, stok, harga, deskripsi, tanggal_ditambahkan, img_path) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $koneksi->prepare($sql)) {
        $stmt->bind_param("sssssss", $nama_obat, $jenis_obat, $stok, $harga, $deskripsi, $tanggal_ditambahkan, $nama_file);

        if ($stmt->execute()) {
            header("Location: obat_index.php");
            exit();
        } else {
            echo "<div class='alert alert-danger mt-4'>Gagal menambahkan Obat: " . $stmt->error . "</div>";
            // Hapus file jika gagal insert ke database
            if(!empty($nama_file) && file_exists($upload_path)) {
                unlink($upload_path);
            }
        }
        $stmt->close();
    } else {
        echo "<div class='alert alert-danger mt-4'>Gagal mempersiapkan statement: " . $koneksi->error . "</div>";
    }

    $koneksi->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Obat</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2 class="mt-4">Tambah Obat</h2>
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="namaobat">Nama Obat</label>
            <input type="text" class="form-control" id="nama_obat" name="nama_obat" required>
        </div>
        <div class="form-group">
            <label for="jenisobat">Jenis Obat</label>
            <input type="text" class="form-control" id="jenis_obat" name="jenis_obat" required>
        </div>
        <div class="form-group">
            <label for="stok">Stok</label>
            <input type="text" class="form-control" id="stok" name="stok" required>
        </div>
        <div class="form-group">
            <label for="harga">Harga</label>
            <input type="text" class="form-control" id="harga" name="harga" required>
        </div>
        <div class="form-group">
            <label for="deskripsi">Deskripsi</label>
            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="5" required></textarea>
        </div>
        <div class="form-group">
            <label for="tanggal">Tanggal Ditambahkan</label>
            <input type="date" class="form-control" id="tanggal_ditambahkan" name="tanggal_ditambahkan" required>
        </div>
        <div class="form-group">
            <label for="img_path">Upload Gambar</label>
            <input type="file" class="form-control" id="img_path" name="img_path" accept="image/*">
            <small class="form-text text-muted">Format yang diizinkan: JPG, JPEG, PNG. Maksimal 2MB</small>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        <a href="obat_index.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js"></script>
</body>
</html>