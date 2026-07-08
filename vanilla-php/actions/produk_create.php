<?php
// Validate CSRF
if (!isset($_POST['csrf_token']) || !verifyCSRFToken($_POST['csrf_token'])) {
    redirectWithMessage('/vanilla-php/admin/produk', 'error', 'Permintaan tidak valid.');
}

// Validate input
$errors = validate($_POST, [
    'nama_produk' => 'required',
    'harga' => 'required',
    'stok' => 'required',
]);

// Handle file upload
$gambar = null;
if (isset($_FILES['gambar']) && $_FILES['gambar']['size'] > 0) {
    $gambar = uploadFile($_FILES['gambar'], 'products/');
    if (!$gambar) {
        $errors['gambar'] = 'Gagal upload gambar. Pastikan file adalah gambar dengan ukuran maksimal 5MB.';
    }
}

if (!empty($errors)) {
    $title = 'Tambah Produk';
    include __DIR__ . '/../../pages/layouts/header.php';
    include __DIR__ . '/../../pages/admin/produk/create.php';
    include __DIR__ . '/../../pages/layouts/footer.php';
    exit();
}

// Insert product
$db = Database::getInstance();
try {
    $db->execute(
        "INSERT INTO produks (nama_produk, harga, stok, deskripsi, gambar, created_at, updated_at) VALUES (?, ?, ?, ?, ?, NOW(), NOW())",
        [
            $_POST['nama_produk'],
            $_POST['harga'],
            $_POST['stok'],
            $_POST['deskripsi'] ?? null,
            $gambar
        ]
    );

    redirectWithMessage('/vanilla-php/admin/produk', 'success', 'Produk berhasil ditambahkan.');
} catch (Exception $e) {
    redirectWithMessage('/vanilla-php/admin/produk/create', 'error', 'Gagal menambahkan produk: ' . $e->getMessage());
}
?>
