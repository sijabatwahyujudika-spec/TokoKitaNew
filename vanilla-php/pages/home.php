<?php
$title = 'Beranda';
include __DIR__ . '/layouts/header.php';

$db = Database::getInstance();
$products = $db->fetchAll("SELECT * FROM produks ORDER BY created_at DESC LIMIT 6");
?>

<section style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 3rem 0; margin-bottom: 3rem; border-radius: 8px;">
    <h2 style="font-size: 2.5rem; margin-bottom: 1rem;">Selamat datang di <?php echo APP_NAME; ?></h2>
    <p style="font-size: 1.1rem;">Tempat terbaik untuk membeli produk berkualitas dengan harga terjangkau</p>
</section>

<div style="margin-bottom: 2rem; text-align: center;">
    <a href="/vanilla-php/produk" class="btn" style="padding: 0.75rem 2rem; font-size: 1rem;">Lihat Semua Produk</a>
</div>

<h3>Produk Terbaru</h3>
<div class="product-grid">
    <?php if ($products): ?>
        <?php foreach ($products as $product): ?>
            <div class="product-card">
                <?php if ($product['gambar']): ?>
                    <img src="<?php echo e($product['gambar']); ?>" alt="<?php echo e($product['nama_produk']); ?>" class="product-image">
                <?php else: ?>
                    <div class="product-image" style="background-color: #ecf0f1; display: flex; align-items: center; justify-content: center;">
                        <span style="color: #7f8c8d;">Tidak ada gambar</span>
                    </div>
                <?php endif; ?>
                <div class="product-info">
                    <h4 class="product-name"><?php echo e($product['nama_produk']); ?></h4>
                    <p class="product-price"><?php echo formatCurrency($product['harga']); ?></p>
                    <p style="font-size: 0.9rem; color: #7f8c8d;">Stok: <?php echo $product['stok']; ?></p>
                    <div class="product-actions">
                        <a href="/vanilla-php/produk/<?php echo $product['id']; ?>" class="btn">Lihat Detail</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p style="grid-column: 1 / -1; text-align: center; color: #7f8c8d;">Belum ada produk tersedia</p>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/layouts/footer.php'; ?>
