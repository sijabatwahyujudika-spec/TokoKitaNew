<?php
$title = 'Detail Produk';
include __DIR__ . '/../layouts/header.php';

$db = Database::getInstance();
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$product = $db->fetch("SELECT * FROM produks WHERE id = ?", [$id]);

if (!$product) {
    http_response_code(404);
    include __DIR__ . '/../404.php';
    exit();
}
?>

<a href="/vanilla-php/produk" style="margin-bottom: 1rem; display: inline-block;">← Kembali ke Produk</a>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; background: white; padding: 2rem; border-radius: 8px;">
    <div>
        <?php if ($product['gambar']): ?>
            <img src="<?php echo e($product['gambar']); ?>" alt="<?php echo e($product['nama_produk']); ?>" style="width: 100%; border-radius: 8px;">
        <?php else: ?>
            <div style="width: 100%; height: 400px; background-color: #ecf0f1; display: flex; align-items: center; justify-content: center; border-radius: 8px;">
                <span style="color: #7f8c8d; font-size: 1.2rem;">Tidak ada gambar</span>
            </div>
        <?php endif; ?>
    </div>

    <div>
        <h2><?php echo e($product['nama_produk']); ?></h2>
        
        <p style="font-size: 1.5rem; color: #27ae60; font-weight: bold; margin: 1rem 0;">
            <?php echo formatCurrency($product['harga']); ?>
        </p>

        <p style="color: <?php echo $product['stok'] > 0 ? '#27ae60' : '#e74c3c'; ?>; font-weight: 500;">
            <?php echo $product['stok'] > 0 ? 'Tersedia (' . $product['stok'] . ' stok)' : 'Stok Habis'; ?>
        </p>

        <h4 style="margin-top: 2rem; margin-bottom: 1rem;">Deskripsi</h4>
        <p style="line-height: 1.6; color: #555;">
            <?php echo e($product['deskripsi'] ?? 'Tidak ada deskripsi'); ?>
        </p>

        <?php if (isLoggedIn() && $product['stok'] > 0): ?>
            <div style="margin-top: 2rem;">
                <a href="/vanilla-php/pesanan/create?produk_id=<?php echo $product['id']; ?>" class="btn btn-success" style="display: inline-block; padding: 0.75rem 2rem;">
                    Pesan Sekarang
                </a>
            </div>
        <?php elseif (!isLoggedIn()): ?>
            <div style="margin-top: 2rem;">
                <p style="color: #7f8c8d; margin-bottom: 1rem;">Silakan login untuk membuat pesanan</p>
                <a href="/vanilla-php/login" class="btn" style="display: inline-block; padding: 0.75rem 2rem;">
                    Login Sekarang
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
