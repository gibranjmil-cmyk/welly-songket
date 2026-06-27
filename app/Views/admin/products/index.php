<?php
$statusClass = ($status ?? 'success') === 'error' ? 'notice notice-error' : 'notice notice-success';
?>
<?php if (($message ?? '') !== ''): ?>
    <div class="<?= $statusClass ?>"><?= e($message) ?></div>
<?php endif; ?>

<div class="admin-page-header">
    <div>
        <p class="eyebrow">Manajemen</p>
        <h1>Produk</h1>
    </div>
</div>

<div class="admin-two-col">
    <!-- Form tambah produk -->
    <div class="admin-panel">
        <h2>Tambah Produk Baru</h2>
        <form method="post" action="<?= url('/admin/products/store') ?>">
            <?= csrf_field() ?>
            <label>Nama produk <span class="req">*</span>
                <input name="name" required placeholder="Contoh: Rok Songket">
            </label>
            <label>Kategori produk
                <select name="category_id">
                    <option value="">-- Pilih kategori --</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= e($cat['id']) ?>"><?= e($cat['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
            <label>Kebutuhan ukuran
                <select name="category">
                    <option value="pakaian">Pakaian</option>
                    <option value="alas_kaki">Sepatu / Sandal</option>
                    <option value="aksesoris_cm">Tas / Dompet (cm)</option>
                    <option value="kain">Kain / Selendang</option>
                    <option value="custom">Custom bebas</option>
                </select>
            </label>
            <label>Deskripsi
                <textarea name="description" placeholder="Deskripsi singkat produk"></textarea>
            </label>
            <button type="submit" class="admin-button">Tambah Produk</button>
        </form>
    </div>

    <!-- Upload media -->
    <div class="admin-panel">
        <h2>Upload Foto / Video Produk</h2>
        <form method="post" action="<?= url('/admin/products/media') ?>" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <label>Produk <span class="req">*</span>
                <select name="product_id" required>
                    <option value="">-- Pilih produk --</option>
                    <?php foreach ($products as $p): ?>
                        <option value="<?= e($p['id']) ?>"><?= e($p['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
            <label>File (gambar/video) <span class="req">*</span>
                <input type="file" name="media" accept="image/*,video/*" required>
            </label>
            <label class="checkbox-label">
                <input type="checkbox" name="is_cover" value="1"> Jadikan foto cover
            </label>
            <button type="submit" class="admin-button">Upload</button>
        </form>
    </div>
</div>

<!-- Daftar produk -->
<div class="admin-panel">
    <div class="panel-head">
        <h2>Daftar Produk (<?= count($products) ?>)</h2>
    </div>
    <?php if (empty($products)): ?>
        <p class="muted" style="padding:16px">Belum ada produk. Tambahkan di form sebelah kiri.</p>
    <?php else: ?>
    <table class="admin-table">
        <thead>
            <tr><th>#</th><th>Nama</th><th>Kategori</th><th>Deskripsi</th><th>Media</th><th>Aksi</th></tr>
        </thead>
        <tbody>
        <?php foreach ($products as $p): ?>
            <tr>
                <td><?= e($p['id']) ?></td>
                <td><strong><?= e($p['name']) ?></strong></td>
                <td><?= e($p['category_name'] ?? $p['category'] ?? '-') ?></td>
                <td class="muted"><?= e(mb_substr($p['description'] ?? '', 0, 60)) ?><?= mb_strlen($p['description'] ?? '') > 60 ? '…' : '' ?></td>
                <td><?= count($p['media'] ?? []) ?> file</td>
                <td class="table-actions">
                    <button class="table-action" onclick="openEditProduct(<?= htmlspecialchars(json_encode($p), ENT_QUOTES) ?>)">Edit</button>
                    <form method="post" action="<?= url('/admin/products/delete') ?>" style="display:inline" onsubmit="return confirm('Hapus produk ini dan semua medianya?')">
                        <?= csrf_field() ?>
                        <input type="hidden" name="id" value="<?= e($p['id']) ?>">
                        <button type="submit" class="table-action danger">Hapus</button>
                    </form>
                </td>
            </tr>
            <?php if (!empty($p['media'])): ?>
            <tr class="media-row">
                <td colspan="6">
                    <div class="media-thumbs">
                    <?php foreach ($p['media'] as $m): ?>
                        <div class="thumb-wrap">
                            <?php if ($m['media_type'] === 'video'): ?>
                                <video src="<?= asset($m['file_name']) ?>" class="thumb-img" muted></video>
                            <?php else: ?>
                                <img src="<?= asset($m['file_name']) ?>" alt="media" class="thumb-img">
                            <?php endif; ?>
                            <?php if ($m['is_cover']): ?><span class="cover-badge">Cover</span><?php endif; ?>
                            <form method="post" action="<?= url('/admin/products/media/delete') ?>" onsubmit="return confirm('Hapus media ini?')">
                                <?= csrf_field() ?>
                                <input type="hidden" name="id" value="<?= e($m['id']) ?>">
                                <button type="submit" class="thumb-del">✕</button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                    </div>
                </td>
            </tr>
            <?php endif; ?>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
</div>

<!-- Modal Edit -->
<div id="editModal" class="modal" style="display:none">
    <div class="modal-box">
        <h3>Edit Produk</h3>
        <form method="post" action="<?= url('/admin/products/update') ?>">
            <?= csrf_field() ?>
            <input type="hidden" name="id" id="edit_id">
            <label>Nama produk <span class="req">*</span>
                <input name="name" id="edit_name" required>
            </label>
            <label>Kategori
                <select name="category_id" id="edit_category_id">
                    <option value="">-- Pilih kategori --</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= e($cat['id']) ?>"><?= e($cat['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
            <label>Deskripsi
                <textarea name="description" id="edit_description"></textarea>
            </label>
            <div class="modal-actions">
                <button type="submit" class="admin-button">Simpan</button>
                <button type="button" class="admin-button secondary" onclick="document.getElementById('editModal').style.display='none'">Batal</button>
            </div>
        </form>
    </div>
</div>
<script>
function openEditProduct(p) {
    document.getElementById('edit_id').value = p.id;
    document.getElementById('edit_name').value = p.name;
    document.getElementById('edit_category_id').value = p.category_id || '';
    document.getElementById('edit_description').value = p.description || '';
    document.getElementById('editModal').style.display = 'flex';
}
</script>
