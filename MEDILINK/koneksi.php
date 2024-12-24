<?php
// Konfigurasi database
$servername = "localhost";
$db_username = "root";
$db_password = ""; // Password database
$db_name = "pawangkesehatan";
$db_port = 3306; // Default port MySQL

// Membuat koneksi
$koneksi = mysqli_connect($servername, $db_username, $db_password, $db_name, $db_port);

// Periksa koneksi
if (!$koneksi) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
} else {
    echo "";
}
?>
