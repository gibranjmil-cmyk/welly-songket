<?php $statusClass = ($status ?? 'success') === 'error' ? 'notice notice-error' : 'notice notice-success'; ?>
<?php if (($message ?? '') !== ''): ?>
    <div class="<?= $statusClass ?>"><?= e($message) ?></div>
<?php endif; ?>

<div class="admin-page-header">
    <div><p class="eyebrow">Manajemen</p><h1>Pesanan</h1></div>
</div>

<!-- Filter status -->
<div class="filter-bar">
    <a href="<?= url('/admin/orders') ?>" class="filter-btn <?= ($statusFilter ?? '') === '' ? 'active' : '' ?>">Semua (<?= array_sum($orderStats) ?>)</a>
    <?php foreach (['Pending', 'Diproses', 'Selesai', 'Dikirim'] as $s): ?>
        <a href="<?= url('/admin/orders?status_filter=' . $s) ?>" class="filter-btn <?= ($statusFilter ?? '') === $s ? 'active' : '' ?>">
            <?= $s ?> (<?= $orderStats[$s] ?? 0 ?>)
        </a>
    <?php endforeach; ?>
</div>

<div class="admin-panel">
    <?php if (empty($orders)): ?>
        <p class="muted" style="padding:16px">Belum ada pesanan.</p>
    <?php else: ?>
    <table class="admin-table">
        <thead>
            <tr><th>#</th><th>Customer</th><th>WhatsApp</th><th>Produk</th><th>Status</th><th>Tanggal</th><th>Aksi</th></tr>
        </thead>
        <tbody>
        <?php foreach ($orders as $order): ?>
            <tr>
                <td><?= e($order['id']) ?></td>
                <td><strong><?= e($order['customer_name']) ?></strong></td>
                <td>
                    <a href="https://wa.me/<?= preg_replace('/\D/', '', $order['phone']) ?>" target="_blank" rel="noopener">
                        <?= e($order['phone']) ?>
                    </a>
                </td>
                <td><?= e($order['product_name'] ?? $order['notes'] ?? '-') ?></td>
                <td>
                    <form method="post" action="<?= url('/admin/orders/status') ?>" style="display:inline">
                        <?= csrf_field() ?>
                        <input type="hidden" name="id" value="<?= e($order['id']) ?>">
                        <select name="order_status" onchange="this.form.submit()" class="status-select status--<?= strtolower($order['status']) ?>">
                            <?php foreach (['Pending', 'Diproses', 'Selesai', 'Dikirim'] as $s): ?>
                                <option value="<?= $s ?>" <?= $order['status'] === $s ? 'selected' : '' ?>><?= $s ?></option>
                            <?php endforeach; ?>
                        </select>
                    </form>
                </td>
                <td><?= e(date('d M Y', strtotime($order['created_at']))) ?></td>
                <td class="table-actions">
                    <a class="table-action" href="<?= url('/admin/orders/show?id=' . $order['id']) ?>">Detail</a>
                    <form method="post" action="<?= url('/admin/orders/delete') ?>" style="display:inline" onsubmit="return confirm('Hapus pesanan ini?')">
                        <?= csrf_field() ?>
                        <input type="hidden" name="id" value="<?= e($order['id']) ?>">
                        <button type="submit" class="table-action danger">Hapus</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
</div>
