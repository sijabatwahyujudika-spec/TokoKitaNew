<?php
$title = 'Buat Pesanan';
include __DIR__ . '/../layouts/header.php';

$db = Database::getInstance();

// Get products for selection
$products = $db->fetchAll("SELECT id, nama_produk, harga FROM produks WHERE stok > 0 ORDER BY nama_produk");

// Package options
$packages = [
    'Basic' => 15000,
    'Standard' => 25000,
    'Premium' => 40000,
];

// Additional services
$services = [
    'Waterproofing' => 5000,
    'Color Treatment' => 3000,
    'Express Delivery' => 10000,
];
?>

<a href="/vanilla-php/pesanan" style="margin-bottom: 1rem; display: inline-block;">← Kembali</a>

<div style="max-width: 600px; background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
    <h2>Buat Pesanan Baru</h2>

    <?php if (isset($errors) && !empty($errors)): ?>
        <div class="alert alert-error">
            <?php foreach ($errors as $field => $error): ?>
                <p><?php echo e($error); ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">

        <div class="form-group">
            <label for="paket">Pilih Paket</label>
            <select id="paket" name="paket" required onchange="updateTotal()">
                <option value="">-- Pilih Paket --</option>
                <?php foreach ($packages as $name => $price): ?>
                    <option value="<?php echo e($name); ?>" data-price="<?php echo $price; ?>">
                        <?php echo e($name); ?> - <?php echo formatCurrency($price); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="jumlah_sepatu">Jumlah Sepatu</label>
            <input type="number" id="jumlah_sepatu" name="jumlah_sepatu" min="1" max="10" value="1" required onchange="updateTotal()">
        </div>

        <div class="form-group">
            <label>Layanan Tambahan (Opsional)</label>
            <div style="display: grid; gap: 0.5rem;">
                <?php foreach ($services as $name => $price): ?>
                    <label style="display: flex; align-items: center; font-weight: normal;">
                        <input type="checkbox" name="layanan_tambahan[]" value="<?php echo e($name); ?>" data-price="<?php echo $price; ?>" onchange="updateTotal()" style="margin-right: 0.5rem;">
                        <span><?php echo e($name); ?> (+<?php echo formatCurrency($price); ?>)</span>
                    </label>
                <?php endforeach; ?>
            </div>
        </div>

        <div style="background-color: #ecf0f1; padding: 1rem; border-radius: 4px; margin-bottom: 1.5rem;">
            <p style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                <span>Harga Paket:</span>
                <span id="paket_price">Rp 0</span>
            </p>
            <p style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                <span>Biaya Tambahan:</span>
                <span id="additional_price">Rp 0</span>
            </p>
            <p style="display: flex; justify-content: space-between; font-weight: bold; font-size: 1.2rem; border-top: 1px solid #ddd; padding-top: 0.5rem;">
                <span>Total:</span>
                <span id="total_price">Rp 0</span>
            </p>
        </div>

        <input type="hidden" id="total_biaya" name="total_biaya" value="0">

        <button type="submit" class="btn btn-success" style="width: 100%; padding: 0.75rem;">Buat Pesanan</button>
    </form>
</div>

<script>
function formatCurrency(amount) {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
    }).format(amount);
}

function updateTotal() {
    const paketSelect = document.getElementById('paket');
    const jumlahInput = document.getElementById('jumlah_sepatu');
    const layananCheckboxes = document.querySelectorAll('input[name="layanan_tambahan[]"]:checked');

    let paketPrice = parseInt(paketSelect.options[paketSelect.selectedIndex].dataset.price) || 0;
    let jumlah = parseInt(jumlahInput.value) || 0;
    let additionalPrice = 0;

    layananCheckboxes.forEach(checkbox => {
        additionalPrice += parseInt(checkbox.dataset.price) || 0;
    });

    const subtotal = (paketPrice * jumlah) + additionalPrice;

    document.getElementById('paket_price').textContent = formatCurrency(paketPrice * jumlah);
    document.getElementById('additional_price').textContent = formatCurrency(additionalPrice);
    document.getElementById('total_price').textContent = formatCurrency(subtotal);
    document.getElementById('total_biaya').value = subtotal;
}

// Initialize
updateTotal();
</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
