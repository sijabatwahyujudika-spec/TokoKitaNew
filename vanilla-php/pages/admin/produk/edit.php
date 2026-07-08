<?php
$title = 'Edit Produk';
include __DIR__ . '/../../layouts/header.php';

$db = Database::getInstance();
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$product = $db->fetch("SELECT * FROM produks WHERE id = ?", [$id]);

if (!$product) {
    http_response_code(404);
    include __DIR__ . '/../../404.php';
    exit();
}
?>

<a href="/vanilla-php/admin/produk" style="margin-bottom: 1rem; display: inline-block;">← Kembali</a>

<div style="max-width: 600px; background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
    <h2>Edit Produk</h2>

    <?php if (isset($errors) && !empty($errors)): ?>
        <div class="alert alert-error">
            <?php foreach ($errors as $field => $error): ?>
                <p><?php echo e($error); ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
        <input type="hidden" name="id" value="<?php echo $product['id']; ?>">

        <div class="form-group">
            <label for="nama_produk">Nama Produk</label>
            <input type="text" id="nama_produk" name="nama_produk" required value="<?php echo e($_POST['nama_produk'] ?? $product['nama_produk']); ?>">
        </div>

        <div class="form-group">
            <label for="harga">Harga (Rp)</label>
            <input type="number" id="harga" name="harga" required value="<?php echo $_POST['harga'] ?? $product['harga']; ?>">
        </div>

        <div class="form-group">
            <label for="stok">Stok</label>
            <input type="number" id="stok" name="stok" required value="<?php echo $_POST['stok'] ?? $product['stok']; ?>">
        </div>

        <div class="form-group">
            <label for="deskripsi">Deskripsi</label>
            <textarea id="deskripsi" name="deskripsi"><?php echo e($_POST['deskripsi'] ?? $product['deskripsi']); ?></textarea>
        </div>

        <div class="form-group">
            <label for="gambar">Gambar Produk</label>
            <?php if ($product['gambar']): ?>
                <div style="margin-bottom: 1rem;">
                    <img src="<?php echo e($product['gambar']); ?>" style="max-width: 200px; max-height: 200px; border-radius: 4px;">
                    <p style="font-size: 0.85rem; color: #7f8c8d; margin-top: 0.5rem;">Gambar saat ini</p>
                </div>
            <?php endif; ?>
            <input type="file" id="gambar" name="gambar" accept="image/*">
            <small style="color: #7f8c8d;">Format: JPG, PNG, GIF. Ukuran maksimal: 5MB. Biarkan kosong jika tidak ingin mengubah.</small>
        </div>

        <button type="submit" class="btn btn-success" style="width: 100%; padding: 0.75rem;">Simpan Perubahan</button>
    </form>
</div>

<?php include __DIR__ . '/../../layouts/footer.php'; ?>
