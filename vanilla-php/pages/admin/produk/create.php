<?php
$title = 'Tambah Produk';
include __DIR__ . '/../../layouts/header.php';
?>

<a href="/vanilla-php/admin/produk" style="margin-bottom: 1rem; display: inline-block;">← Kembali</a>

<div style="max-width: 600px; background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
    <h2>Tambah Produk Baru</h2>

    <?php if (isset($errors) && !empty($errors)): ?>
        <div class="alert alert-error">
            <?php foreach ($errors as $field => $error): ?>
                <p><?php echo e($error); ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">

        <div class="form-group">
            <label for="nama_produk">Nama Produk</label>
            <input type="text" id="nama_produk" name="nama_produk" required value="<?php echo e($_POST['nama_produk'] ?? ''); ?>">
        </div>

        <div class="form-group">
            <label for="harga">Harga (Rp)</label>
            <input type="number" id="harga" name="harga" required value="<?php echo $_POST['harga'] ?? ''; ?>">
        </div>

        <div class="form-group">
            <label for="stok">Stok</label>
            <input type="number" id="stok" name="stok" required value="<?php echo $_POST['stok'] ?? '0'; ?>">
        </div>

        <div class="form-group">
            <label for="deskripsi">Deskripsi</label>
            <textarea id="deskripsi" name="deskripsi"><?php echo e($_POST['deskripsi'] ?? ''); ?></textarea>
        </div>

        <div class="form-group">
            <label for="gambar">Gambar Produk</label>
            <input type="file" id="gambar" name="gambar" accept="image/*">
            <small style="color: #7f8c8d;">Format: JPG, PNG, GIF. Ukuran maksimal: 5MB</small>
        </div>

        <button type="submit" class="btn btn-success" style="width: 100%; padding: 0.75rem;">Simpan Produk</button>
    </form>
</div>

<?php include __DIR__ . '/../../layouts/footer.php'; ?>
