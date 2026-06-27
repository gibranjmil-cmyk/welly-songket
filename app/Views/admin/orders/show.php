<div class="admin-page-header">
    <div><p class="eyebrow">Detail</p><h1>Pesanan #<?= e($order['id']) ?></h1></div>
    <a href="<?= url('/admin/orders') ?>" class="admin-button secondary">← Kembali</a>
</div>

<div class="admin-two-col">
    <div class="admin-panel">
        <h2>Info Customer</h2>
        <dl class="detail-list">
            <dt>Nama</dt><dd><?= e($order['customer_name']) ?></dd>
            <dt>WhatsApp</dt>
            <dd><a href="https://wa.me/<?= preg_replace('/\D/', '', $order['phone']) ?>" target="_blank"><?= e($order['phone']) ?></a></dd>
            <dt>Alamat</dt><dd><?= nl2br(e($order['address'])) ?></dd>
            <dt>Tanggal</dt><dd><?= e(date('d M Y H:i', strtotime($order['created_at']))) ?></dd>
        </dl>
    </div>

    <div class="admin-panel">
        <h2>Detail Pesanan</h2>
        <dl class="detail-list">
            <dt>Produk</dt><dd><?= e($order['product_name'] ?? '-') ?></dd>
            <dt>Catatan</dt><dd><?= nl2br(e($order['notes'] ?? '-')) ?></dd>
            <dt>Status</dt>
            <dd>
                <form method="post" action="<?= url('/admin/orders/status') ?>">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id" value="<?= e($order['id']) ?>">
                    <select name="order_status" onchange="this.form.submit()" class="status-select">
                        <?php foreach (['Pending','Diproses','Selesai','Dikirim'] as $s): ?>
                            <option value="<?= $s ?>" <?= $order['status'] === $s ? 'selected' : '' ?>><?= $s ?></option>
                        <?php endforeach; ?>
                    </select>
                </form>
            </dd>
        </dl>
    </div>
</div>

<?php if (!empty($order['sizes'])): ?>
<div class="admin-panel">
    <h2>Ukuran</h2>
    <dl class="detail-list">
        <?php $labels = ['tinggi_badan'=>'Tinggi Badan','berat_badan'=>'Berat Badan','lebar_bahu'=>'Lebar Bahu','lebar_dada'=>'Lebar Dada','panjang_lengan'=>'Panjang Lengan','panjang_badan'=>'Panjang Badan','panjang_kaki'=>'Panjang Kaki']; ?>
        <?php foreach ($labels as $key => $label): ?>
            <?php if (!empty($order['sizes'][$key])): ?>
                <dt><?= $label ?></dt>
                <dd><?= e($order['sizes'][$key]) ?> cm</dd>
            <?php endif; ?>
        <?php endforeach; ?>
    </dl>
</div>
<?php endif; ?>
