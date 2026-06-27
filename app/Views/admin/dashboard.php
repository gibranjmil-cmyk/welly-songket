<?php
$pending   = $orderStats['Pending']  ?? 0;
$diproses  = $orderStats['Diproses'] ?? 0;
$selesai   = $orderStats['Selesai']  ?? 0;
$dikirim   = $orderStats['Dikirim']  ?? 0;
$totalOrder= $pending + $diproses + $selesai + $dikirim;
$statusClass = ($status ?? 'success') === 'error' ? 'notice notice-error' : 'notice notice-success';
?>

<?php if (($message ?? '') !== ''): ?>
    <div class="<?= $statusClass ?>"><?= e($message) ?></div>
<?php endif; ?>

<div class="admin-page-header">
    <div>
        <p class="eyebrow">Overview</p>
        <h1>Dashboard Admin</h1>
    </div>
    <a class="admin-button" href="<?= url('/') ?>" target="_blank">Lihat Website</a>
</div>

<div class="stat-grid">
    <div class="stat-card">
        <span class="stat-label">Total Pesanan</span>
        <strong class="stat-value"><?= $totalOrder ?></strong>
    </div>
    <div class="stat-card stat-card--yellow">
        <span class="stat-label">Pending</span>
        <strong class="stat-value"><?= $pending ?></strong>
    </div>
    <div class="stat-card stat-card--blue">
        <span class="stat-label">Diproses</span>
        <strong class="stat-value"><?= $diproses ?></strong>
    </div>
    <div class="stat-card stat-card--green">
        <span class="stat-label">Selesai / Dikirim</span>
        <strong class="stat-value"><?= $selesai + $dikirim ?></strong>
    </div>
    <div class="stat-card">
        <span class="stat-label">Total Produk</span>
        <strong class="stat-value"><?= $productCount ?? 0 ?></strong>
    </div>
    <div class="stat-card">
        <span class="stat-label">Total Motif</span>
        <strong class="stat-value"><?= $motifCount ?? 0 ?></strong>
    </div>
</div>

<div class="admin-panel">
    <div class="panel-head">
        <h2>Pesanan Terbaru</h2>
        <a href="<?= url('/admin/orders') ?>">Lihat semua →</a>
    </div>
    <?php if (empty($recentOrders)): ?>
        <p class="muted" style="padding:16px">Belum ada pesanan masuk.</p>
    <?php else: ?>
    <table class="admin-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Customer</th>
                <th>WhatsApp</th>
                <th>Produk</th>
                <th>Status</th>
                <th>Tanggal</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($recentOrders as $order): ?>
            <tr>
                <td><?= e($order['id']) ?></td>
                <td><?= e($order['customer_name']) ?></td>
                <td><?= e($order['phone']) ?></td>
                <td><?= e($order['product_name'] ?? '-') ?></td>
                <td><span class="badge badge--<?= strtolower(str_replace(' ', '-', $order['status'])) ?>"><?= e($order['status']) ?></span></td>
                <td><?= e(date('d M Y', strtotime($order['created_at']))) ?></td>
                <td><a class="table-action" href="<?= url('/admin/orders/show?id=' . $order['id']) ?>">Detail</a></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
</div>

<div class="quick-links">
    <a href="<?= url('/admin/products') ?>" class="quick-card">
        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M20 7H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
        <span>Kelola Produk</span>
    </a>
    <a href="<?= url('/admin/motifs') ?>" class="quick-card">
        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M12 2v3M12 19v3M4.22 4.22l2.12 2.12M17.66 17.66l2.12 2.12M2 12h3M19 12h3M4.22 19.78l2.12-2.12M17.66 6.34l2.12-2.12"/></svg>
        <span>Kelola Motif</span>
    </a>
    <a href="<?= url('/admin/orders') ?>" class="quick-card">
        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M9 17H7A5 5 0 0 1 7 7h2"/><path d="M15 7h2a5 5 0 0 1 0 10h-2"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
        <span>Kelola Pesanan</span>
    </a>
    <a href="<?= url('/admin/categories') ?>" class="quick-card">
        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
        <span>Kategori</span>
    </a>
</div>
