<?php
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    redirectWithMessage('/vanilla-php/admin/produk', 'error', 'ID produk tidak valid.');
}

$db = Database::getInstance();
$product = $db->fetch("SELECT * FROM produks WHERE id = ?", [$id]);

if (!$product) {
    redirectWithMessage('/vanilla-php/admin/produk', 'error', 'Produk tidak ditemukan.');
}

// Delete product
try {
    $db->execute("DELETE FROM produks WHERE id = ?", [$id]);
    redirectWithMessage('/vanilla-php/admin/produk', 'success', 'Produk berhasil dihapus.');
} catch (Exception $e) {
    redirectWithMessage('/vanilla-php/admin/produk', 'error', 'Gagal menghapus produk: ' . $e->getMessage());
}
?>
