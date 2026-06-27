<?php $statusClass = ($status ?? 'success') === 'error' ? 'notice notice-error' : 'notice notice-success'; ?>
<?php if (($message ?? '') !== ''): ?>
    <div class="<?= $statusClass ?>"><?= e($message) ?></div>
<?php endif; ?>

<div class="admin-page-header">
    <div><p class="eyebrow">Manajemen</p><h1>Motif</h1></div>
</div>

<div class="admin-two-col">
    <div class="admin-panel">
        <h2>Tambah Motif Baru</h2>
        <form method="post" action="<?= url('/admin/motifs/store') ?>" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <label>Nama motif <span class="req">*</span>
                <input name="name" required placeholder="Contoh: Pucuk Rabuang">
            </label>
            <label>Kategori
                <select name="category_id">
                    <option value="">-- Pilih kategori --</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= e($cat['id']) ?>"><?= e($cat['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
            <label>Keywords (dipisah koma)
                <input name="keywords" placeholder="tradisional, minang, emas">
            </label>
            <label>Filosofi
                <textarea name="philosophy" placeholder="Makna dan filosofi di balik motif ini"></textarea>
            </label>
            <label>Deskripsi
                <textarea name="description" placeholder="Keterangan motif"></textarea>
            </label>
            <label>Foto referensi motif
                <input type="file" name="reference_image" accept="image/*">
            </label>
            <button type="submit" class="admin-button">Tambah Motif</button>
        </form>
    </div>

    <div class="admin-panel">
        <h2>Info Motif</h2>
        <p class="muted">Motif yang ditambahkan di sini akan tampil sebagai pilihan saat customer mengisi form preorder di halaman utama.</p>
        <hr style="border-color:var(--line);margin:16px 0">
        <p class="muted"><strong><?= count($motifs) ?></strong> motif terdaftar dalam sistem.</p>
        <p class="muted"><strong><?= count($categories) ?></strong> kategori motif tersedia.</p>
    </div>
</div>

<div class="admin-panel">
    <div class="panel-head">
        <h2>Daftar Motif (<?= count($motifs) ?>)</h2>
    </div>
    <?php if (empty($motifs)): ?>
        <p class="muted" style="padding:16px">Belum ada motif. Tambahkan di form di atas.</p>
    <?php else: ?>
    <table class="admin-table">
        <thead>
            <tr><th>#</th><th>Nama</th><th>Kategori</th><th>Keywords</th><th>Referensi</th><th>Aksi</th></tr>
        </thead>
        <tbody>
        <?php foreach ($motifs as $m): ?>
            <tr>
                <td><?= e($m['id']) ?></td>
                <td><strong><?= e($m['name']) ?></strong></td>
                <td><?= e($m['category_name'] ?? '-') ?></td>
                <td class="muted"><?= e($m['keywords'] ?? '-') ?></td>
                <td>
                    <?php if ($m['reference_image']): ?>
                        <img src="<?= asset($m['reference_image']) ?>" alt="ref" style="height:40px;border-radius:4px;object-fit:cover">
                    <?php else: ?>
                        <span class="muted">-</span>
                    <?php endif; ?>
                </td>
                <td class="table-actions">
                    <button class="table-action" onclick="openEditMotif(<?= htmlspecialchars(json_encode($m), ENT_QUOTES) ?>)">Edit</button>
                    <form method="post" action="<?= url('/admin/motifs/delete') ?>" style="display:inline" onsubmit="return confirm('Hapus motif ini?')">
                        <?= csrf_field() ?>
                        <input type="hidden" name="id" value="<?= e($m['id']) ?>">
                        <button type="submit" class="table-action danger">Hapus</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
</div>

<div id="editMotifModal" class="modal" style="display:none">
    <div class="modal-box">
        <h3>Edit Motif</h3>
        <form method="post" action="<?= url('/admin/motifs/update') ?>">
            <?= csrf_field() ?>
            <input type="hidden" name="id" id="em_id">
            <label>Nama motif <span class="req">*</span><input name="name" id="em_name" required></label>
            <label>Kategori
                <select name="category_id" id="em_category_id">
                    <option value="">-- Pilih kategori --</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= e($cat['id']) ?>"><?= e($cat['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
            <label>Keywords<input name="keywords" id="em_keywords"></label>
            <label>Filosofi<textarea name="philosophy" id="em_philosophy"></textarea></label>
            <label>Deskripsi<textarea name="description" id="em_description"></textarea></label>
            <div class="modal-actions">
                <button type="submit" class="admin-button">Simpan</button>
                <button type="button" class="admin-button secondary" onclick="document.getElementById('editMotifModal').style.display='none'">Batal</button>
            </div>
        </form>
    </div>
</div>
<script>
function openEditMotif(m) {
    document.getElementById('em_id').value          = m.id;
    document.getElementById('em_name').value        = m.name;
    document.getElementById('em_category_id').value = m.category_id || '';
    document.getElementById('em_keywords').value    = m.keywords || '';
    document.getElementById('em_philosophy').value  = m.philosophy || '';
    document.getElementById('em_description').value = m.description || '';
    document.getElementById('editMotifModal').style.display = 'flex';
}
</script>
