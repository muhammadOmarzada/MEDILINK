<!DOCTYPE html>
<html>
<head>
    <title>Update Nomor Darurat</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
<?php
// Include database connection
require_once "koneksi.php";

// Input sanitization function
function input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Initialize variables
$error_message = '';
$success_message = '';
$data = [];

// Validate and get ID
if (isset($_GET['id_nomordarurat']) && is_numeric($_GET['id_nomordarurat'])) {
    $id_nomordarurat = intval($_GET['id_nomordarurat']);

    try {
        $sql = "SELECT * FROM nomor_darurat WHERE id_nomordarurat = ?";
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param("i", $id_nomordarurat);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $data = $result->fetch_assoc();
        } else {
            die("<div class='alert alert-danger'>Data tidak ditemukan.</div>");
        }
    } catch (Exception $e) {
        die("<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>");
    }
} else {
    die("<div class='alert alert-danger'>ID Nomor Darurat tidak valid.</div>");
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Validate input
        $id_nomordarurat = filter_input(INPUT_POST, 'id_nomordarurat', FILTER_VALIDATE_INT);
        $nama_rs = input($_POST["nama_rs"]);
        $nomor_rs = input($_POST["nomor_rs"]);
        
        // Validate phone number format
        if (!preg_match("/^[0-9\-\+]{6,20}$/", $nomor_rs)) {
            throw new Exception("Format nomor telepon tidak valid.");
        }

        $nama_file = $data['img_path']; // Keep existing image by default

        // Handle image upload if new file is selected
        if (isset($_FILES['img_path']) && $_FILES['img_path']['error'] === UPLOAD_ERR_OK) {
            $allowed = ['jpg', 'jpeg', 'png'];
            $filename = $_FILES['img_path']['name'];
            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            
            // Validate file extension
            if (!in_array($ext, $allowed)) {
                throw new Exception("Hanya file JPG, JPEG, atau PNG yang diizinkan.");
            }
            
            // Validate file size (2MB max)
            if ($_FILES['img_path']['size'] > 2 * 1024 * 1024) {
                throw new Exception("Ukuran file maksimal adalah 2MB.");
            }
            
            // Generate unique filename
            $nama_file = uniqid() . '_' . time() . '.' . $ext;
            $upload_dir = "uploads/";
            $upload_path = $upload_dir . $nama_file;
            
            // Create upload directory if it doesn't exist
            if (!file_exists($upload_dir)) {
                if (!mkdir($upload_dir, 0777, true)) {
                    throw new Exception("Gagal membuat direktori upload.");
                }
            }
            
            // Move uploaded file
            if (!move_uploaded_file($_FILES['img_path']['tmp_name'], $upload_path)) {
                throw new Exception("Gagal mengupload file.");
            }
            
            // Delete old file if exists
            if (!empty($data['img_path']) && file_exists($upload_dir . $data['img_path'])) {
                unlink($upload_dir . $data['img_path']);
            }
        }

        // Update database
        $sql = "UPDATE nomor_darurat SET nama_rs = ?, nomor_rs = ?, img_path = ? WHERE id_nomordarurat = ?";
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param("sssi", $nama_rs, $nomor_rs, $nama_file, $id_nomordarurat);
        
        if ($stmt->execute()) {
            $success_message = "Data berhasil diupdate!";
            // Reload data to show updated values
            $data['nama_rs'] = $nama_rs;
            $data['nomor_rs'] = $nomor_rs;
            $data['img_path'] = $nama_file;
        } else {
            throw new Exception("Gagal mengupdate data.");
        }
        
    } catch (Exception $e) {
        $error_message = $e->getMessage();
    }
}
?>

<!-- Display Messages -->
<?php if ($error_message): ?>
    <div class="alert alert-danger"><?php echo $error_message; ?></div>
<?php endif; ?>

<?php if ($success_message): ?>
    <div class="alert alert-success"><?php echo $success_message; ?></div>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        <h2 class="mb-0">Update Data Nomor Darurat</h2>
    </div>
    <div class="card-body">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id_nomordarurat=" . $id_nomordarurat); ?>" 
              method="post" 
              enctype="multipart/form-data"
              class="needs-validation" 
              novalidate>
            
            <div class="form-group">
                <label for="nama_rs">Nama Rumah Sakit:</label>
                <input type="text" 
                       name="nama_rs" 
                       id="nama_rs"
                       class="form-control" 
                       placeholder="Masukan Nama Rumah Sakit" 
                       value="<?php echo htmlspecialchars($data['nama_rs']); ?>" 
                       required />
                <div class="invalid-feedback">
                    Nama Rumah Sakit harus diisi
                </div>
            </div>

            <div class="form-group">
                <label for="nomor_rs">Nomor Rumah Sakit:</label>
                <input type="text" 
                       name="nomor_rs" 
                       id="nomor_rs"
                       class="form-control" 
                       placeholder="Masukan Nomor Rumah Sakit" 
                       value="<?php echo htmlspecialchars($data['nomor_rs']); ?>" 
                       pattern="[0-9\-\+]{6,20}"
                       required />
                <div class="invalid-feedback">
                    Masukkan nomor telepon yang valid
                </div>
                <small class="form-text text-muted">Format: minimal 6 digit, hanya angka, tanda minus (-) dan plus (+)</small>
            </div>

            <div class="form-group">
                <label>Gambar Saat Ini:</label>
                <?php if(!empty($data['img_path']) && file_exists("uploads/" . $data['img_path'])): ?>
                    <div class="mb-2">
                        <img src="uploads/<?php echo htmlspecialchars($data['img_path']); ?>" 
                             alt="Gambar RS" 
                             class="img-thumbnail" 
                             style="max-width: 200px">
                    </div>
                <?php else: ?>
                    <p class="text-muted">Tidak ada gambar</p>
                <?php endif; ?>
                
                <label for="img_path">Upload Gambar Baru:</label>
                <input type="file" 
                       class="form-control" 
                       id="img_path" 
                       name="img_path" 
                       accept="image/jpeg,image/png">
                <small class="form-text text-muted">
                    Format yang diizinkan: JPG, JPEG, PNG. Maksimal 2MB
                </small>
            </div>

            <input type="hidden" name="id_nomordarurat" value="<?php echo $data['id_nomordarurat']; ?>" />
            
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Update Data</button>
                <a href="nomor_darurat_index.php" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>
</div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Form validation script
(function() {
    'use strict';
    window.addEventListener('load', function() {
        var forms = document.getElementsByClassName('needs-validation');
        var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();
</script>
</body>
</html>