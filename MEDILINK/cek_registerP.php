<?php
require 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($koneksi, $_POST["username"]);
    $nama_lengkap = mysqli_real_escape_string($koneksi, $_POST["nama_lengkap"]);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Cek apakah username sudah ada
    $check_sql = "SELECT * FROM pengguna WHERE username = ?";
    $check_stmt = mysqli_prepare($koneksi, $check_sql);
    mysqli_stmt_bind_param($check_stmt, "s", $username);
    mysqli_stmt_execute($check_stmt);
    $result = mysqli_stmt_get_result($check_stmt);

    if (mysqli_num_rows($result) > 0) {
        echo "Username sudah digunakan!";
        exit;
    }

    // Generate unique_id
    $unique_id = rand(time(), 100000000);
    $status = "Active now";
    $new_img_name = "default.png"; // Default image

    // Handle image upload if exists
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $img_name = $_FILES['image']['name'];
        $tmp_name = $_FILES['image']['tmp_name'];
        $img_explode = explode('.', $img_name);
        $img_ext = strtolower(end($img_explode));

        $extensions = ["jpeg", "png", "jpg"];
        
        if (in_array($img_ext, $extensions)) {
            $time = time();
            $new_img_name = $time . $img_name;
            
            if (!move_uploaded_file($tmp_name, "images/" . $new_img_name)) {
                echo "Gagal mengupload gambar!";
                exit;
            }
        }
    }

    // Insert data menggunakan prepared statement
    $query_sql = "INSERT INTO pengguna (password, username, nama_lengkap, img_path, status) 
                  VALUES (?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($koneksi, $query_sql);
    mysqli_stmt_bind_param($stmt, "sssss", $password, $username, $nama_lengkap, $new_img_name, $status);

    if (mysqli_stmt_execute($stmt)) {
        // Set session
        session_start();
        header("Location: loginP.php");
        exit;
    } else {
        echo "Pendaftaran Gagal: " . mysqli_error($koneksi);
    }

    mysqli_stmt_close($stmt);
    mysqli_stmt_close($check_stmt);
} else {
    echo "Method tidak diizinkan!";
}
?>