<?php
session_start();
unset($_SESSION['username']);
unset($_SESSION['password']);
unset($_SESSION['nama_lengkap']);

session_destroy();
echo "<script>alert('logout berhasil');
document.location='loginP.php'</script>";
?>