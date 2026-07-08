<?php
// Validate CSRF
if (!isset($_POST['csrf_token']) || !verifyCSRFToken($_POST['csrf_token'])) {
    redirectWithMessage('/vanilla-php/admin/produk', 'error', 'Permintaan tidak valid.');
}

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
if ($id <= 0) {
    redirectWithMessage('/vanilla-php/admin/produk', 'error', 'ID produk tidak valid.');
}

// Validate input
$errors = validate($_POST, [
    'nama_produk' => 'required',
    'harga' => 'required',
    'stok' => 'required',
]);

$db = Database::getInstance();
$product = $db->fetch("SELECT * FROM produks WHERE id = ?", [$id]);

if (!$product) {
    redirectWithMessage('/vanilla-php/admin/produk', 'error', 'Produk tidak ditemukan.');
}

// Handle file upload
$gambar = $product['gambar'];
if (isset($_FILES['gambar']) && $_FILES['gambar']['size'] > 0) {
    $gambar = uploadFile($_FILES['gambar'], 'products/');
    if (!$gambar) {
        $errors['gambar'] = 'Gagal upload gambar. Pastikan file adalah gambar dengan ukuran maksimal 5MB.';
    }
}

if (!empty($errors)) {
    $_GET['id'] = $id;
    $_POST['nama_produk'] = $_POST['nama_produk'];
    $_POST['harga'] = $_POST['harga'];
    $_POST['stok'] = $_POST['stok'];
    $_POST['deskripsi'] = $_POST['deskripsi'] ?? '';
    $title = 'Edit Produk';
    include __DIR__ . '/../../pages/layouts/header.php';
    include __DIR__ . '/../../pages/admin/produk/edit.php';
    include __DIR__ . '/../../pages/layouts/footer.php';
    exit();
}

// Update product
try {
    $db->execute(
        "UPDATE produks SET nama_produk = ?, harga = ?, stok = ?, deskripsi = ?, gambar = ?, updated_at = NOW() WHERE id = ?",
        [
            $_POST['nama_produk'],
            $_POST['harga'],
            $_POST['stok'],
            $_POST['deskripsi'] ?? null,
            $gambar,
            $id
        ]
    );

    redirectWithMessage('/vanilla-php/admin/produk', 'success', 'Produk berhasil diperbarui.');
} catch (Exception $e) {
    $_GET['id'] = $id;
    redirectWithMessage('/vanilla-php/admin/produk/' . $id . '/edit', 'error', 'Gagal memperbarui produk: ' . $e->getMessage());
}
?>
