<?php
session_start();
require_once 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['cart_id'])) {
        $cart_id = (int)$_POST['cart_id'];
        
        try {
            $stmt = $pdo->prepare("DELETE FROM keranjang WHERE id = ?");
            $result = $stmt->execute([$cart_id]);
            
            if($result) {
                header('Location: marketplace.php?status=success&message=' . urlencode('Item berhasil dihapus'));
            } else {
                header('Location: marketplace.php?status=error&message=' . urlencode('Gagal menghapus item'));
            }
        } catch (PDOException $e) {
            header('Location: marketplace.php?status=error&message=' . urlencode($e->getMessage()));
        }
    }
}
exit;
?>