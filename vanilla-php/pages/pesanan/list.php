<?php
$title = 'Pesanan Saya';
include __DIR__ . '/../layouts/header.php';

$db = Database::getInstance();
$user = getCurrentUser();

$pesanans = $db->fetchAll(
    "SELECT * FROM pesanans WHERE user_id = ? ORDER BY created_at DESC",
    [$user['user_id']]
);
?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <h2>Pesanan Saya</h2>
    <a href="/vanilla-php/pesanan/create" class="btn btn-success">+ Buat Pesanan Baru</a>
</div>

<?php if (!empty($pesanans)): ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Paket</th>
                <th>Jumlah Sepatu</th>
                <th>Total Biaya</th>
                <th>Status</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pesanans as $pesanan): ?>
                <tr>
                    <td>#<?php echo $pesanan['id']; ?></td>
                    <td><?php echo e($pesanan['paket']); ?></td>
                    <td><?php echo $pesanan['jumlah_sepatu']; ?></td>
                    <td><?php echo formatCurrency($pesanan['total_biaya']); ?></td>
                    <td>
                        <span style="display: inline-block; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.85rem; 
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
                    </td>
                    <td><?php echo date('d/m/Y H:i', strtotime($pesanan['created_at'])); ?></td>
                    <td>
                        <a href="/vanilla-php/pesanan/detail?id=<?php echo $pesanan['id']; ?>" class="btn" style="padding: 0.25rem 0.75rem; font-size: 0.85rem;">Lihat</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p style="text-align: center; color: #7f8c8d; padding: 2rem;">
        Anda belum memiliki pesanan. <a href="/vanilla-php/pesanan/create" style="color: #3498db; font-weight: 500;">Buat pesanan sekarang</a>
    </p>
<?php endif; ?>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
