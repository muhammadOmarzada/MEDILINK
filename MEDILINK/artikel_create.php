<!DOCTYPE html>
<html>
<head>
    <title>Buat Artikel</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2 class="mt-4">Buat Artikel Baru</h2>
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="judulartikel">Judul Artikel</label>
            <input type="text" class="form-control" id="judulartikel" name="judulartikel" required>
        </div>
        <div class="form-group">
            <label for="penulisartikel">Penulis Artikel</label>
            <input type="text" class="form-control" id="penulisartikel" name="penulisartikel" required>
        </div>
        <div class="form-group">
            <label for="isiartikel">Isi Artikel</label>
            <textarea class="form-control" id="isiartikel" name="isiartikel" rows="5" required></textarea>
        </div>
        <div class="form-group">
            <label for="gambar">Gambar Artikel</label>
            <input type="file" class="form-control-file" id="gambar" name="gambar" accept="image/*" required>
            <small class="form-text text-muted">Format yang diizinkan: JPG, JPEG, PNG. Maksimal 2MB</small>
        </div>
        <div class="form-group">
            <label for="tanggal">Tanggal</label>
            <input type="date" class="form-control" id="tanggal" name="tanggal" required>
        </div>
        <div class="form-group">
            <label for="kategori">Kategori</label>
            <input type="text" class="form-control" id="kategori" name="kategori" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<?php
include "koneksi.php";
session_start();

function create_slug($title) {
    $slug = strtolower($title);
    $slug = preg_replace('/[^a-z0-9-]/', '-', $slug);
    $slug = preg_replace('/-+/', '-', $slug);
    $slug = substr($slug, 0, 100);
    $slug = trim($slug, '-');
    $slug .= '-' . bin2hex(random_bytes(3));
    return $slug;
}

function slug_exists($slug, $koneksi) {
    $sql = "SELECT COUNT(*) as count FROM artikel WHERE slug = ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("s", $slug);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();
    return $row['count'] > 0;
}

function input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = [];
    $stmt = null; // Inisialisasi $stmt di luar try-catch

    if (!isset($_SESSION['id_admin'])) {
        $errors[] = "Anda harus login sebagai admin terlebih dahulu";
    }

    $required_fields = [
        'judulartikel' => 'Judul Artikel',
        'penulisartikel' => 'Penulis Artikel', 
        'isiartikel' => 'Isi Artikel',
        'tanggal' => 'Tanggal',
        'kategori' => 'Kategori'
    ];

    foreach ($required_fields as $field => $label) {
        if (empty($_POST[$field])) {
            $errors[] = "$label tidak boleh kosong";
        }
    }

    // Validasi file gambar
    if (!isset($_FILES['gambar']) || $_FILES['gambar']['error'] === UPLOAD_ERR_NO_FILE) {
        $errors[] = "Gambar artikel wajib diupload";
    } else {
        $file = $_FILES['gambar'];
        $allowed_types = ['image/jpeg', 'image/jpg', 'image/png'];
        $max_size = 2 * 1024 * 1024; // 2MB

        if (!in_array($file['type'], $allowed_types)) {
            $errors[] = "Format file tidak diizinkan. Gunakan JPG, JPEG, atau PNG";
        }

        if ($file['size'] > $max_size) {
            $errors[] = "Ukuran file terlalu besar. Maksimal 2MB";
        }
    }

    if (!empty($errors)) {
        echo "<div class='alert alert-danger'>";
        foreach ($errors as $error) {
            echo "<p>$error</p>";
        }
        echo "</div>";
    } else {
        $judulartikel = input($_POST["judulartikel"]);
        $penulisartikel = input($_POST["penulisartikel"]);
        $isiartikel = input($_POST["isiartikel"]);
        $tanggal = input($_POST["tanggal"]);
        $kategori = input($_POST["kategori"]);
        $id_admin = $_SESSION['id_admin'];
        $slug = create_slug($judulartikel);

        // Proses upload gambar
        $upload_dir = "uploads/"; // Direktori upload
        
        // Buat direktori jika belum ada
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // Mendapatkan informasi file
        $file = $_FILES['gambar'];
        $file_extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $filename = $slug . '.' . $file_extension;
        $upload_path = $upload_dir . $filename;
        $img_path = $upload_dir . $filename; // Path yang akan disimpan di database

        $koneksi->begin_transaction();

        try {
            // Cek dan buat direktori jika belum ada
            if (!is_dir($upload_dir)) {
                if (!mkdir($upload_dir, 0777, true)) {
                    throw new Exception("Gagal membuat direktori upload");
                }
            }

            // Validasi format gambar
            $valid_extensions = ['jpg', 'jpeg', 'png'];
            if (!in_array($file_extension, $valid_extensions)) {
                throw new Exception("Format file tidak valid. Gunakan JPG, JPEG, atau PNG");
            }

            // Upload dan validasi file
            if (!move_uploaded_file($file['tmp_name'], $upload_path)) {
                throw new Exception("Gagal mengupload gambar");
            }

            // Compress gambar jika ukurannya terlalu besar
            if (filesize($upload_path) > 2 * 1024 * 1024) { // 2MB
                $compressed = false;
                
                if ($file_extension == 'jpg' || $file_extension == 'jpeg') {
                    $image = imagecreatefromjpeg($upload_path);
                    $compressed = imagejpeg($image, $upload_path, 60); // Kompresi 60%
                    imagedestroy($image);
                } elseif ($file_extension == 'png') {
                    $image = imagecreatefrompng($upload_path);
                    $compressed = imagepng($image, $upload_path, 6); // Kompresi level 6
                    imagedestroy($image);
                }

                if (!$compressed) {
                    throw new Exception("Gagal mengkompresi gambar");
                }
            }

            $sql = "INSERT INTO artikel (
                judulartikel, 
                penulisartikel, 
                isiartikel, 
                tanggal, 
                kategori, 
                slug,
                id_admin,
                img_path
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = $koneksi->prepare($sql);

            if (!$stmt) {
                throw new Exception("Gagal mempersiapkan statement: " . $koneksi->error);
            }

            $stmt->bind_param(
                "ssssssis", 
                $judulartikel, 
                $penulisartikel, 
                $isiartikel, 
                $tanggal, 
                $kategori, 
                $slug,
                $id_admin,
                $img_path
            );

            if (!$stmt->execute()) {
                throw new Exception("Gagal menambahkan artikel: " . $stmt->error);
            }

            $koneksi->commit();

            echo "<div class='alert alert-success mt-4'>
                    Artikel berhasil ditambahkan. 
                    <br>ID Artikel: " . $stmt->insert_id . "
                    <br>ID Admin: " . $id_admin . "
                    <br>Gambar: " . $img_path . "
                  </div>";

        } catch (Exception $e) {
            $koneksi->rollback();
            // Hapus file yang sudah diupload jika ada error
            if (file_exists($upload_path)) {
                unlink($upload_path);
            }
            echo "<div class='alert alert-danger mt-4'>" . $e->getMessage() . "</div>";
        }

        if ($stmt) {
            $stmt->close();
        }
    }
}
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js"></script>
</body>
</html>