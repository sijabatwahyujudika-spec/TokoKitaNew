<?php
$title = 'Manajemen Produk';
include __DIR__ . '/../../layouts/header.php';

$db = Database::getInstance();

$products = $db->fetchAll("SELECT * FROM produks ORDER BY created_at DESC");
?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <h2>Manajemen Produk</h2>
    <a href="/vanilla-php/admin/produk/create" class="btn btn-success">+ Tambah Produk</a>
</div>

<?php if (!empty($products)): ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Gambar</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?php echo $product['id']; ?></td>
                    <td><?php echo e($product['nama_produk']); ?></td>
                    <td><?php echo formatCurrency($product['harga']); ?></td>
                    <td><?php echo $product['stok']; ?></td>
                    <td>
                        <?php if ($product['gambar']): ?>
                            <img src="<?php echo e($product['gambar']); ?>" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                        <?php else: ?>
                            <span style="color: #7f8c8d; font-size: 0.85rem;">Tidak ada</span>
                        <?php endif; ?>
                    </td>
                    <td><?php echo date('d/m/Y', strtotime($product['created_at'])); ?></td>
                    <td style="display: flex; gap: 0.5rem;">
                        <a href="/vanilla-php/admin/produk/<?php echo $product['id']; ?>/edit" class="btn" style="padding: 0.25rem 0.75rem; font-size: 0.85rem;">Edit</a>
                        <a href="/vanilla-php/admin/produk/<?php echo $product['id']; ?>/delete" class="btn btn-danger" style="padding: 0.25rem 0.75rem; font-size: 0.85rem;" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p style="text-align: center; color: #7f8c8d; padding: 2rem;">
        Belum ada produk. <a href="/vanilla-php/admin/produk/create" style="color: #3498db; font-weight: 500;">Tambah produk pertama Anda</a>
    </p>
<?php endif; ?>

<?php include __DIR__ . '/../../layouts/footer.php'; ?>
