<?php
include "koneksi.php";

function input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_rs = input($_POST["nama_rs"]);
    $nomor_rs = input($_POST["nomor_rs"]);
    
    // Inisialisasi variabel untuk nama file
    $nama_file = "";
    $upload_path = "";
    
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

    // Query untuk memasukkan data ke tabel nomor_darurat
    $sql = "INSERT INTO nomor_darurat (nama_rs, nomor_rs, img_path) 
            VALUES (?, ?, ?)";

    if ($stmt = $koneksi->prepare($sql)) {
        $stmt->bind_param("sss", $nama_rs, $nomor_rs, $nama_file);

        if ($stmt->execute()) {
            header("Location: nomor_darurat_index.php");
            exit();
        } else {
            echo "<div class='alert alert-danger mt-4'>Gagal menambahkan data: " . $stmt->error . "</div>";
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
    <title>Tambah Nomor</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2 class="mt-4">Tambah Nomor</h2>
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="nama_rs">Nama RS</label>
            <input type="text" class="form-control" id="nama_rs" name="nama_rs" required>
        </div>
        <div class="form-group">
            <label for="nomor_rs">Nomor RS</label>
            <input type="text" class="form-control" id="nomor_rs" name="nomor_rs" required>
        </div>
        <div class="form-group">
            <label for="img_path">Upload Gambar</label>
            <input type="file" class="form-control" id="img_path" name="img_path" accept="image/*">
            <small class="form-text text-muted">Format yang diizinkan: JPG, JPEG, PNG. Maksimal 2MB</small>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        <a href="nomor_darurat_index.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js"></script>
</body>
</html>