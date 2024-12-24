<?php
session_start();
require_once 'koneksi.php';

if(!isset($_SESSION['id_pengguna'])) {
    header("Location: loginP.php");
    exit();
}


try {
    if (!isset($_SESSION['session_id']) || !isset($_SESSION['id_pengguna'])) {
        throw new Exception('Session tidak ditemukan');
    }

    $session_id = $_SESSION['session_id'];
    
    // Mulai transaksi
    mysqli_begin_transaction($koneksi);

    // 1. Ambil data keranjang
    $cart_query = "SELECT k.*, o.harga FROM keranjang k 
                   JOIN obat o ON k.produk_id = o.id_obat 
                   WHERE k.session_id = ?";
    $stmt = mysqli_prepare($koneksi, $cart_query);
    mysqli_stmt_bind_param($stmt, 's', $session_id);
    mysqli_stmt_execute($stmt);
    $cart_items = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($cart_items) == 0) {
        throw new Exception('Keranjang kosong');
    }

    // 2. Hitung total pembayaran
    $total_pembayaran = 0;
    $items_data = [];
    while ($item = mysqli_fetch_assoc($cart_items)) {
        $subtotal = $item['harga'] * $item['jumlah'];
        $total_pembayaran += $subtotal;
        $items_data[] = $item;
    }

    // 3. Buat pesanan baru
    $no_pesanan = 'ORD' . date('YmdHis') . rand(100, 999);
    $id_pengguna = $_SESSION['id_pengguna'];

    $insert_order = "INSERT INTO pesanan (no_pesanan, id_pengguna, total_pembayaran) 
                     VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($koneksi, $insert_order);
    mysqli_stmt_bind_param($stmt, 'sid', $no_pesanan, $id_pengguna, $total_pembayaran);
    
    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception('Gagal membuat pesanan');
    }
    
    $id_pesanan = mysqli_insert_id($koneksi);

    // 4. Masukkan detail pesanan
    foreach ($items_data as $item) {
        $subtotal = $item['harga'] * $item['jumlah'];
        $detail_query = "INSERT INTO detail_pesanan (id_pesanan, id_pengguna, id_obat, jumlah, harga, subtotal) 
        VALUES (?, ?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($koneksi, $detail_query);
mysqli_stmt_bind_param($stmt, 'iiiidd', 
$id_pesanan,
$id_pengguna, // tambahkan ini
$item['produk_id'], 
$item['jumlah'], 
$item['harga'], 
$subtotal
);
mysqli_stmt_execute($stmt);

    }

    // 5. Hapus keranjang
    $delete_query = "DELETE FROM keranjang WHERE session_id = ?";
    $stmt = mysqli_prepare($koneksi, $delete_query);
    mysqli_stmt_bind_param($stmt, 's', $session_id);
    mysqli_stmt_execute($stmt);

    // Commit transaksi
    mysqli_commit($koneksi);
    
    // Redirect ke halaman monitoring pesanan
    header('Location: monitor_pesanan.php?order=' . $no_pesanan);

} catch (Exception $e) {
    mysqli_rollback($koneksi);
    header('Location: marketplace.php?status=error&message=' . urlencode($e->getMessage()));
    echo $e->getMessage();
    $id_pengguna = $_SESSION['id_pengguna'];
$query = "DELETE FROM detail_pesanan WHERE id_pengguna = '$id_pengguna'";
error_log("Query DELETE: $query");
mysqli_query($koneksi, $query);

}
exit;