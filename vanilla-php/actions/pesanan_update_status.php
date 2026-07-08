<?php
// Validate CSRF
if (!isset($_POST['csrf_token']) || !verifyCSRFToken($_POST['csrf_token'])) {
    redirectWithMessage('/vanilla-php/admin/pesanan', 'error', 'Permintaan tidak valid.');
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    redirectWithMessage('/vanilla-php/admin/pesanan', 'error', 'ID pesanan tidak valid.');
}

// Validate input
if (empty($_POST['status'])) {
    redirectWithMessage('/vanilla-php/admin/pesanan/' . $id, 'error', 'Status harus dipilih.');
}

$db = Database::getInstance();
$pesanan = $db->fetch("SELECT * FROM pesanans WHERE id = ?", [$id]);

if (!$pesanan) {
    redirectWithMessage('/vanilla-php/admin/pesanan', 'error', 'Pesanan tidak ditemukan.');
}

// Update status
try {
    $db->execute(
        "UPDATE pesanans SET status = ?, updated_at = NOW() WHERE id = ?",
        [$_POST['status'], $id]
    );

    redirectWithMessage('/vanilla-php/admin/pesanan/' . $id, 'success', 'Status pesanan berhasil diperbarui.');
} catch (Exception $e) {
    redirectWithMessage('/vanilla-php/admin/pesanan/' . $id, 'error', 'Gagal memperbarui status: ' . $e->getMessage());
}
?>
