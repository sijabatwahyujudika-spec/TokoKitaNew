<?php
$title = 'Detail Pesanan - Admin';
include __DIR__ . '/../../layouts/header.php';

$db = Database::getInstance();
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$pesanan = $db->fetch(
    "SELECT p.*, u.name, u.email FROM pesanans p LEFT JOIN users u ON p.user_id = u.id WHERE p.id = ?",
    [$id]
);

if (!$pesanan) {
    http_response_code(404);
    include __DIR__ . '/../../404.php';
    exit();
}

$services = $pesanan['layanan_tambahan'] ? json_decode($pesanan['layanan_tambahan']) : [];

// Status options for admin
$statusOptions = [
    'Menunggu Pembayaran',
    'Pembayaran Diterima',
    'Sedang Diproses',
    'Selesai',
    'Dibatalkan'
];
?>

<a href="/vanilla-php/admin/pesanan" style="margin-bottom: 1rem; display: inline-block;">← Kembali</a>

<div style="max-width: 700px; background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
    <h2>Detail Pesanan #<?php echo $pesanan['id']; ?></h2>

    <div style="margin: 2rem 0; padding: 1rem; background-color: #ecf0f1; border-radius: 4px;">
        <p style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
            <span><strong>Status:</strong></span>
            <span style="display: inline-block; padding: 0.25rem 0.75rem; border-radius: 20px; 
                background-color: <?php 
                if (strpos($pesanan['status'], 'Selesai') !== false) {
                    echo '#d4edda';
                } elseif (strpos($pesanan['status'], 'Proses') !== false) {
                    echo '#fff3cd';
                } else {
                    echo '#f8d7da';
                }
            ?>;
                color: <?php 
                if (strpos($pesanan['status'], 'Selesai') !== false) {
                    echo '#155724';
                } elseif (strpos($pesanan['status'], 'Proses') !== false) {
                    echo '#856404';
                } else {
                    echo '#721c24';
                }
            ?>;">
                <?php echo e($pesanan['status']); ?>
            </span>
        </p>
        <p style="display: flex; justify-content: space-between; margin-bottom: 0;">
            <span><strong>Tanggal Pesanan:</strong></span>
            <span><?php echo date('d/m/Y H:i', strtotime($pesanan['created_at'])); ?></span>
        </p>
    </div>

    <h4>Informasi Pemesan</h4>
    <table style="width: 100%; margin-bottom: 2rem;">
        <tr>
            <td style="padding: 0.5rem 0; border-bottom: 1px solid #ddd;"><strong>Nama:</strong></td>
            <td style="padding: 0.5rem 0; border-bottom: 1px solid #ddd;"><?php echo e($pesanan['name']); ?></td>
        </tr>
        <tr>
            <td style="padding: 0.5rem 0;"><strong>Email:</strong></td>
            <td style="padding: 0.5rem 0;"><?php echo e($pesanan['email']); ?></td>
        </tr>
    </table>

    <h4>Informasi Pesanan</h4>
    <table style="width: 100%; margin-bottom: 2rem;">
        <tr>
            <td style="padding: 0.5rem 0; border-bottom: 1px solid #ddd;"><strong>Paket:</strong></td>
            <td style="padding: 0.5rem 0; border-bottom: 1px solid #ddd; text-align: right;"><?php echo e($pesanan['paket']); ?></td>
        </tr>
        <tr>
            <td style="padding: 0.5rem 0; border-bottom: 1px solid #ddd;"><strong>Jumlah Sepatu:</strong></td>
            <td style="padding: 0.5rem 0; border-bottom: 1px solid #ddd; text-align: right;"><?php echo $pesanan['jumlah_sepatu']; ?> pasang</td>
        </tr>
        <?php if (!empty($services)): ?>
            <tr>
                <td style="padding: 0.5rem 0; border-bottom: 1px solid #ddd;"><strong>Layanan Tambahan:</strong></td>
                <td style="padding: 0.5rem 0; border-bottom: 1px solid #ddd; text-align: right;">
                    <?php echo implode(', ', array_map('e', $services)); ?>
                </td>
            </tr>
        <?php endif; ?>
        <tr>
            <td style="padding: 1rem 0; font-size: 1.2rem;"><strong>Total Biaya:</strong></td>
            <td style="padding: 1rem 0; font-size: 1.2rem; text-align: right; color: #27ae60; font-weight: bold;">
                <?php echo formatCurrency($pesanan['total_biaya']); ?>
            </td>
        </tr>
    </table>

    <h4>Ubah Status Pesanan</h4>
    <form method="POST">
        <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
        
        <div class="form-group">
            <label for="status">Status Baru</label>
            <select id="status" name="status" required>
                <?php foreach ($statusOptions as $option): ?>
                    <option value="<?php echo e($option); ?>" <?php echo $pesanan['status'] === $option ? 'selected' : ''; ?>>
                        <?php echo e($option); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-success" style="width: 100%; padding: 0.75rem;">Simpan Perubahan Status</button>
    </form>
</div>

<?php include __DIR__ . '/../../layouts/footer.php'; ?>
