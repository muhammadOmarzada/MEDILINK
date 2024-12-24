<?php
session_start();
require 'koneksi.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = $_POST['password'];
    
    // Debugging
    echo "Username yang diinput: " . $username . "<br>";
    
    // Query untuk mendapatkan data admin
    $query = "SELECT id_admin, username, password FROM admin WHERE username = ?";
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    // Debugging
    echo "Jumlah hasil query: " . mysqli_num_rows($result) . "<br>";
    
    if ($row = mysqli_fetch_assoc($result)) {
        // Debugging
        echo "Password dari database: " . $row['password'] . "<br>";
        echo "Password yang diinput (sebelum verify): " . $password . "<br>";
        
        if (password_verify($password, $row['password'])) {
            $_SESSION['id_admin'] = $row['id_admin'];
            $_SESSION['username'] = $row['username'];
            header("Location: artikel_index.php");
            exit();
        } else {
            echo "Password tidak cocok<br>";
        }
    } else {
        echo "Username tidak ditemukan<br>";
    }
    
    // Jika login gagal
    header("Location: loginAdmin.php?error=1");
    exit();
}

// Debugging session
var_dump($_SESSION);
?>