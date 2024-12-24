<?php
session_start();
unset($_SESSION['username']);
unset($_SESSION['password']);
unset($_SESSION['email']);

session_destroy();
echo "<script>alert('logout berhasil');
document.location='loginAdmin.php'</script>";
?>