<?php
require 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($koneksi, $_POST["username"]);
    $email = mysqli_real_escape_string($koneksi, $_POST["email"]);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Cek apakah username sudah ada
    $check_sql = "SELECT * FROM admin WHERE username = ?";
    $check_stmt = mysqli_prepare($koneksi, $check_sql);
    mysqli_stmt_bind_param($check_stmt, "s", $username);
    mysqli_stmt_execute($check_stmt);
    $result = mysqli_stmt_get_result($check_stmt);

    if (mysqli_num_rows($result) > 0) {
        echo "Username sudah digunakan!";
        exit;
    }

    // Insert data menggunakan prepared statement
    $query_sql = "INSERT INTO admin (password, username, email) 
                  VALUES (?, ?, ?)";

    $stmt = mysqli_prepare($koneksi, $query_sql);
    mysqli_stmt_bind_param($stmt, "sss", $password, $username, $email);

    if (mysqli_stmt_execute($stmt)) {
        // Set session
        session_start();
        $_SESSION['id_admin'] = $id_admin;
        header("Location: loginAdmin.php");
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