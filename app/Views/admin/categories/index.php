<?php $statusClass = ($status ?? 'success') === 'error' ? 'notice notice-error' : 'notice notice-success'; ?>
<?php if (($message ?? '') !== ''): ?>
    <div class="<?= $statusClass ?>"><?= e($message) ?></div>
<?php endif; ?>

<div class="admin-page-header">
    <div><p class="eyebrow">Manajemen</p><h1>Kategori</h1></div>
</div>

<div class="admin-two-col">
    <!-- Kategori Produk -->
    <div class="admin-panel">
        <h2>Kategori Produk</h2>
        <form method="post" action="<?= url('/admin/categories/product/store') ?>" style="display:flex;gap:8px;margin-bottom:16px">
            <?= csrf_field() ?>
            <input name="name" required placeholder="Nama kategori baru" style="flex:1">
            <button type="submit" class="admin-button">Tambah</button>
        </form>
        <?php if (empty($productCategories)): ?>
            <p class="muted">Belum ada kategori produk.</p>
        <?php else: ?>
        <table class="admin-table">
            <thead><tr><th>#</th><th>Nama</th><th>Status</th><th></th></tr></thead>
            <tbody>
            <?php foreach ($productCategories as $cat): ?>
                <tr>
                    <td><?= e($cat['id']) ?></td>
                    <td><?= e($cat['name']) ?></td>
                    <td><span class="badge badge--aktif"><?= e($cat['status']) ?></span></td>
                    <td>
                        <form method="post" action="<?= url('/admin/categories/product/delete') ?>" style="display:inline" onsubmit="return confirm('Hapus kategori ini?')">
                            <?= csrf_field() ?>
                            <input type="hidden" name="id" value="<?= e($cat['id']) ?>">
                            <button type="submit" class="table-action danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>

    <!-- Kategori Motif -->
    <div class="admin-panel">
        <h2>Kategori Motif</h2>
        <form method="post" action="<?= url('/admin/categories/motif/store') ?>" style="display:flex;gap:8px;margin-bottom:16px">
            <?= csrf_field() ?>
            <input name="name" required placeholder="Nama kategori baru" style="flex:1">
            <button type="submit" class="admin-button">Tambah</button>
        </form>
        <?php if (empty($motifCategories)): ?>
            <p class="muted">Belum ada kategori motif.</p>
        <?php else: ?>
        <table class="admin-table">
            <thead><tr><th>#</th><th>Nama</th><th>Status</th><th></th></tr></thead>
            <tbody>
            <?php foreach ($motifCategories as $cat): ?>
                <tr>
                    <td><?= e($cat['id']) ?></td>
                    <td><?= e($cat['name']) ?></td>
                    <td><span class="badge badge--aktif"><?= e($cat['status']) ?></span></td>
                    <td>
                        <form method="post" action="<?= url('/admin/categories/motif/delete') ?>" style="display:inline" onsubmit="return confirm('Hapus kategori ini?')">
                            <?= csrf_field() ?>
                            <input type="hidden" name="id" value="<?= e($cat['id']) ?>">
                            <button type="submit" class="table-action danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
</div>
