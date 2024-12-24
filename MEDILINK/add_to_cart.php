<?php
session_start();
require_once 'koneksi.php';

// Pastikan pengguna sudah login dan memiliki id_pengguna
if (!isset($_SESSION['id_pengguna'])) {
    $_SESSION['error'] = "Anda harus login untuk menambahkan produk ke keranjang.";
    header('Location: login.php');
    exit;
}

// Pastikan session_id tersedia
if (!isset($_SESSION['session_id'])) {
    $_SESSION['session_id'] = session_id();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_obat']) && isset($_POST['quantity'])) {
    $product_id = (int)$_POST['id_obat'];
    $quantity = (int)$_POST['quantity'];
    $session_id = $_SESSION['session_id'];
    $id_pengguna = $_SESSION['id_pengguna'];

    try {
        // Mulai transaksi
        mysqli_begin_transaction($koneksi);

        // Periksa ketersediaan stok dengan FOR UPDATE untuk mengunci baris
        $stmt = mysqli_prepare($koneksi, "SELECT stok FROM obat WHERE id_obat = ? FOR UPDATE");
        mysqli_stmt_bind_param($stmt, "i", $product_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $product = mysqli_fetch_assoc($result);

        if (!$product) {
            mysqli_rollback($koneksi);
            $_SESSION['error'] = "Produk tidak ditemukan.";
            header('Location: marketplace.php');
            exit;
        }

        if ($quantity > $product['stok']) {
            mysqli_rollback($koneksi);
            $_SESSION['error'] = "Jumlah yang diminta melebihi stok yang tersedia.";
            header('Location: marketplace.php');
            exit;
        }

        // Periksa apakah produk sudah ada di keranjang
        $stmt = mysqli_prepare($koneksi, 
            "SELECT id, jumlah FROM keranjang 
             WHERE session_id = ? AND produk_id = ? AND id_pengguna = ?");
        mysqli_stmt_bind_param($stmt, "sii", $session_id, $product_id, $id_pengguna);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $existing_item = mysqli_fetch_assoc($result);

        if ($existing_item) {
            // Perbarui jumlah jika produk sudah ada
            $new_quantity = $existing_item['jumlah'] + $quantity;
            
            if ($new_quantity > $product['stok']) {
                mysqli_rollback($koneksi);
                $_SESSION['error'] = "Total jumlah di keranjang melebihi stok yang tersedia.";
                header('Location: marketplace.php');
                exit;
            }

            $stmt = mysqli_prepare($koneksi, 
                "UPDATE keranjang SET jumlah = ? WHERE id = ? AND id_pengguna = ?");
            mysqli_stmt_bind_param($stmt, "iii", $new_quantity, $existing_item['id'], $id_pengguna);
            mysqli_stmt_execute($stmt);
        } else {
            // Tambahkan item baru jika produk belum ada
            $stmt = mysqli_prepare($koneksi, 
                "INSERT INTO keranjang (session_id, produk_id, jumlah, id_pengguna) 
                 VALUES (?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "siii", $session_id, $product_id, $quantity, $id_pengguna);
            mysqli_stmt_execute($stmt);
        }

        // Commit transaksi jika semua operasi berhasil
        mysqli_commit($koneksi);

        $_SESSION['success'] = "Produk berhasil ditambahkan ke keranjang.";
        header('Location: marketplace.php');
        exit;
    } catch (Exception $e) {
        // Rollback jika terjadi kesalahan
        mysqli_rollback($koneksi);
        $_SESSION['error'] = "Terjadi kesalahan: " . $e->getMessage();
        header('Location: marketplace.php');
        exit;
    }
} else {
    $_SESSION['error'] = "Invalid request.";
    header('Location: marketplace.php');
    exit;
}
?>