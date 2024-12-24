<!DOCTYPE html>
<html>
<head>
    <title>Update Artikel</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container">
<?php
include "koneksi.php";

function input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (isset($_GET['id_obat'])) {
    $id_obat = input($_GET['id_obat']);

    $sql = "SELECT * FROM obat WHERE id_obat=$id_obat";
    $hasil = mysqli_query($koneksi, $sql);

    if ($hasil && mysqli_num_rows($hasil) > 0) {
        $data = mysqli_fetch_assoc($hasil);
    } else {
        echo "<div class='alert alert-danger'> Data tidak ditemukan.</div>";
        exit;
    }
} else {
    echo "<div class='alert alert-danger'> ID Obat tidak ditemukan.</div>";
    exit;
}


// ... kode sebelumnya tetap sama sampai bagian POST ...

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_obat = input($_POST["id_obat"]);
    $nama_obat = input($_POST["nama_obat"]);
    $jenis_obat = input($_POST["jenis_obat"]);
    $stok = input($_POST["stok"]);
    $harga = input($_POST["harga"]);
    $deskripsi = input($_POST["deskripsi"]);
    $tanggal_ditambahkan = input($_POST["tanggal_ditambahkan"]);
    
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

    // Query update data
    $sql = "UPDATE obat SET 
            nama_obat='$nama_obat',
            jenis_obat='$jenis_obat',
            stok='$stok',
            harga='$harga',
            deskripsi='$deskripsi',
            tanggal_ditambahkan='$tanggal_ditambahkan'
            $query_gambar
            WHERE id_obat=$id_obat";

    $hasil = mysqli_query($koneksi, $sql);

    if ($hasil) {
        header("Location:obat_index.php");
        exit;
    } else {
        echo "<div class='alert alert-danger'> Data gagal disimpan: " . mysqli_error($koneksi) . "</div>";
    }
}
?>

<h2>Update Data Obat</h2>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id_obat=$id_obat"); ?>" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label>Nama Obat:</label>
        <input type="text" name="nama_obat" class="form-control" placeholder="Masukan Nama Obat" value="<?php echo $data['nama_obat']; ?>" required />
    </div>
    <div class="form-group">
        <label>Jenis Obat:</label>
        <input type="text" name="jenis_obat" class="form-control" placeholder="Masukan Jenis Obat" value="<?php echo $data['jenis_obat']; ?>" required />
    </div>
    <div class="form-group">
        <label>Stok:</label>
        <input type="number" name="stok" class="form-control" placeholder="Masukan Stok" value="<?php echo $data['stok']; ?>" required />
    </div>
    <div class="form-group">
        <label>Harga:</label>
        <input type="number" name="harga" class="form-control" placeholder="Masukan Harga" value="<?php echo $data['harga']; ?>" required />
    </div>
    <div class="form-group">
        <label>Deskripsi:</label>
        <textarea name="deskripsi" class="form-control" rows="5" placeholder="Masukan Deskripsi" required><?php echo $data['deskripsi']; ?></textarea>
    </div>
    <div class="form-group">
        <label>Tanggal Ditambahkan:</label>
        <input type="date" name="tanggal_ditambahkan" class="form-control" value="<?php echo date('Y-m-d', strtotime($data['tanggal_ditambahkan'])); ?>" required />
    </div>
    <div class="form-group">
        <label>Gambar Saat Ini:</label>
        <?php if(!empty($data['img_path']) && file_exists("uploads/" . $data['img_path'])): ?>
            <div class="mb-2">
                <img src="uploads/<?php echo $data['img_path']; ?>" alt="Gambar Obat" class="img-thumbnail" style="max-width: 200px">
            </div>
        <?php else: ?>
            <p class="text-muted">Tidak ada gambar</p>
        <?php endif; ?>
        <label for="gambar">Upload Gambar Baru:</label>
        <input type="file" class="form-control" id="gambar" name="img_path" accept="image/*">
        <small class="form-text text-muted">Format yang diizinkan: JPG, JPEG, PNG. Maksimal 2MB</small>
    </div>
    <input type="hidden" name="id_obat" value="<?php echo $data['id_obat']; ?>" />
    <button type="submit" class="btn btn-primary">Submit</button>
    <a href="obat_index.php" class="btn btn-secondary">Kembali</a>
</form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js"></script>
</body>
</html>