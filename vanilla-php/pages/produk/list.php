<?php
$title = 'Produk';
include __DIR__ . '/../layouts/header.php';

$db = Database::getInstance();
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;

$totalProducts = $db->fetch("SELECT COUNT(*) as count FROM produks");
$pagination = paginate($page, $totalProducts['count'], 12);

$products = $db->fetchAll(
    "SELECT * FROM produks ORDER BY created_at DESC LIMIT ? OFFSET ?",
    [$pagination['limit'], $pagination['offset']]
);
?>

<h2>Daftar Produk</h2>

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
                    <p style="font-size: 0.9rem; color: <?php echo $product['stok'] > 0 ? '#27ae60' : '#e74c3c'; ?>;">
                        Stok: <?php echo $product['stok']; ?>
                    </p>
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

<?php if ($pagination['total'] > 1): ?>
<div style="margin-top: 2rem; text-align: center;">
    <?php if ($pagination['current'] > 1): ?>
        <a href="/vanilla-php/produk?page=<?php echo $pagination['current'] - 1; ?>" class="btn" style="margin-right: 0.5rem;">← Sebelumnya</a>
    <?php endif; ?>

    <span style="margin: 0 1rem;">Halaman <?php echo $pagination['current']; ?> dari <?php echo $pagination['total']; ?></span>

    <?php if ($pagination['current'] < $pagination['total']): ?>
        <a href="/vanilla-php/produk?page=<?php echo $pagination['current'] + 1; ?>" class="btn">Berikutnya →</a>
    <?php endif; ?>
</div>
<?php endif; ?>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
