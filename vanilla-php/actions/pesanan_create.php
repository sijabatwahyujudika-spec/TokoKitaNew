<?php
// Validate CSRF
if (!isset($_POST['csrf_token']) || !verifyCSRFToken($_POST['csrf_token'])) {
    redirectWithMessage('/vanilla-php/pesanan/create', 'error', 'Permintaan tidak valid.');
}

// Validate input
$errors = validate($_POST, [
    'paket' => 'required',
    'jumlah_sepatu' => 'required',
    'total_biaya' => 'required',
]);

if (!empty($errors)) {
    $title = 'Buat Pesanan';
    include __DIR__ . '/../pages/layouts/header.php';
    include __DIR__ . '/../pages/pesanan/create.php';
    include __DIR__ . '/../pages/layouts/footer.php';
    exit();
}

// Prepare data
$db = Database::getInstance();
$user = getCurrentUser();
$layanan = isset($_POST['layanan_tambahan']) ? json_encode($_POST['layanan_tambahan']) : null;

// Insert order
try {
    $db->execute(
        "INSERT INTO pesanans (user_id, paket, jumlah_sepatu, layanan_tambahan, total_biaya, status, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())",
        [
            $user['user_id'],
            $_POST['paket'],
            $_POST['jumlah_sepatu'],
            $layanan,
            $_POST['total_biaya'],
            'Menunggu Pembayaran'
        ]
    );

    redirectWithMessage('/vanilla-php/pesanan', 'success', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran.');
} catch (Exception $e) {
    $errors['general'] = 'Terjadi kesalahan saat membuat pesanan: ' . $e->getMessage();
    $title = 'Buat Pesanan';
    include __DIR__ . '/../pages/layouts/header.php';
    include __DIR__ . '/../pages/pesanan/create.php';
    include __DIR__ . '/../pages/layouts/footer.php';
    exit();
}
?>
