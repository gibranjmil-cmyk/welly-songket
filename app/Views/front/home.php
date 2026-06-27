<?php
$products = $content['products'] ?? [];
$motifs = $content['motifs'] ?? [];
$productMedia = $content['product_media'] ?? [];
$motifMedia = $content['motif_media'] ?? [];
$videos = $content['videos'] ?? [];
?>

<header class="site-header">
    <a class="brand" href="<?= url('/') ?>" aria-label="Welly Songket">
        <span class="brand-mark">WS</span>
        <span>
            <strong>Welly Songket</strong>
            <small>Pandai Sikek</small>
        </span>
    </a>
    <nav class="social-links" aria-label="Tautan sosial">
        <a href="<?= e($instagramUrl) ?>" target="_blank" rel="noopener">Instagram</a>
        <a href="<?= e($tiktokUrl) ?>" target="_blank" rel="noopener">TikTok</a>
        <a href="https://wa.me/<?= e($whatsappNumber) ?>" target="_blank" rel="noopener">WhatsApp</a>
    </nav>
</header>

<main>
    <section class="hero-section">
        <div class="hero-copy">
            <p class="eyebrow">Preorder songket custom</p>
            <h1>Welly Songket</h1>
            <p class="lead">Pesan selendang, tas, dompet, sepatu, sandal, baju kurung, baju basiba, kemeja, dan produk songket lain sesuai motif, ukuran, dan catatan personal.</p>
            <div class="hero-actions">
                <a class="button primary" href="#preorder">Mulai Preorder</a>
                <a class="button secondary" href="#motif">Lihat Motif</a>
            </div>
        </div>
        <div class="hero-panel" aria-label="Ringkasan layanan">
            <div>
                <span>Motif utama</span>
                <strong>Pucuk Rabuang</strong>
                <p>Motif khas Pandai Sikek, tetapi customer bebas memilih motif lain tanpa batasan.</p>
            </div>
            <div>
                <span>Pembayaran</span>
                <strong>Setelah sepakat</strong>
                <p>Tidak ada estimasi pengerjaan tetap. Semua menyesuaikan pesanan dan negosiasi akhir.</p>
            </div>
        </div>
    </section>

    <section class="content-band" id="produk">
        <div class="section-heading">
            <p class="eyebrow">Produk preorder</p>
            <h2>Satu halaman, satu tujuan: customer mengirim detail pesanan ke WhatsApp.</h2>
        </div>
        <div class="product-grid">
            <?php foreach ($products as $product): ?>
                <article class="item-card">
                    <h3><?= e($product['name'] ?? '') ?></h3>
                    <p><?= e($product['description'] ?? 'Produk songket custom sesuai kebutuhan customer.') ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="media-section" id="motif">
        <div class="section-heading">
            <p class="eyebrow">Galeri</p>
            <h2>Foto motif dan foto produk dibuat terpisah agar admin mudah mengatur katalog.</h2>
        </div>
        <div class="gallery-columns">
            <div>
                <h3>Foto Motif</h3>
                <div class="media-grid">
                    <?php foreach ($motifMedia as $media): ?>
                        <figure>
                            <img src="<?= asset((string) ($media['file'] ?? '')) ?>" alt="<?= e($media['title'] ?? 'Foto motif') ?>">
                            <figcaption><?= e($media['title'] ?? 'Motif') ?></figcaption>
                        </figure>
                    <?php endforeach; ?>
                    <?php if ($motifMedia === []): ?>
                        <p class="empty-note">Admin bisa menambahkan foto motif dari dashboard.</p>
                    <?php endif; ?>
                </div>
            </div>
            <div>
                <h3>Foto Produk</h3>
                <div class="media-grid">
                    <?php foreach ($productMedia as $media): ?>
                        <figure>
                            <img src="<?= asset((string) ($media['file'] ?? '')) ?>" alt="<?= e($media['title'] ?? 'Foto produk') ?>">
                            <figcaption><?= e($media['title'] ?? 'Produk') ?></figcaption>
                        </figure>
                    <?php endforeach; ?>
                    <?php if ($productMedia === []): ?>
                        <p class="empty-note">Admin bisa menambahkan foto produk dari dashboard.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php if ($videos !== []): ?>
            <div class="video-strip">
                <?php foreach ($videos as $video): ?>
                    <video controls src="<?= asset((string) ($video['file'] ?? '')) ?>"></video>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>

    <section class="order-section" id="preorder">
        <div class="order-copy">
            <p class="eyebrow">Form preorder</p>
            <h2>Isi detail, lalu diskusi lanjut di WhatsApp.</h2>
            <p>Customer wajib mengisi nama, alamat, dan nomor WhatsApp. Produk dan motif tidak dibatasi, ukuran bisa ditulis custom karena songket harus fit dan nyaman dipakai.</p>
        </div>

        <form class="order-form" id="orderForm" data-whatsapp="<?= e($whatsappNumber) ?>">
            <div class="form-grid">
                <label>Nama customer
                    <input name="customer_name" type="text" required placeholder="Nama lengkap">
                </label>
                <label>Nomor WhatsApp
                    <input name="customer_whatsapp" type="tel" required placeholder="08xxxxxxxxxx">
                </label>
            </div>
            <label>Alamat
                <textarea name="customer_address" required placeholder="Alamat lengkap customer"></textarea>
            </label>

            <div class="order-items" id="orderItems">
                <div class="order-item" data-item>
                    <div class="item-head">
                        <strong>Produk 1</strong>
                        <button type="button" class="ghost-button" data-remove-item>Hapus</button>
                    </div>
                    <div class="form-grid">
                        <label>Nama produk
                            <select name="product[]" data-product-select required>
                                <option value="">Pilih produk</option>
                                <?php foreach ($products as $product): ?>
                                    <option value="<?= e($product['name'] ?? '') ?>" data-category="<?= e($product['category'] ?? 'custom') ?>"><?= e($product['name'] ?? '') ?></option>
                                <?php endforeach; ?>
                                <option value="Produk custom" data-category="custom">Produk custom lain</option>
                            </select>
                        </label>
                        <label>Motif
                            <input name="motif[]" list="motifList" placeholder="Bebas, contoh: Pucuk Rabuang">
                        </label>
                    </div>
                    <div class="size-fields" data-size-fields>
                        <label>Ukuran dan detail custom
                            <textarea name="sizes[]" placeholder="Tulis ukuran sesuai kebutuhan customer. Contoh pakaian: tinggi badan, berat badan, lebar bahu, lingkar dada, panjang baju, panjang lengan, panjang bawahan/rok songket."></textarea>
                        </label>
                    </div>
                    <label>Deskripsi / catatan produk
                        <textarea name="notes[]" placeholder="Warna, model, jumlah, request motif tambahan, atau catatan kenyamanan."></textarea>
                    </label>
                </div>
            </div>

            <datalist id="motifList">
                <?php foreach ($motifs as $motif): ?>
                    <option value="<?= e($motif['name'] ?? '') ?>"></option>
                <?php endforeach; ?>
            </datalist>

            <button type="button" class="button secondary full" id="addItem">Tambah Produk Lagi</button>

            <label>Link foto referensi
                <input name="reference" type="url" placeholder="Opsional: Google Drive, Instagram, Pinterest, dll">
            </label>
            <label>Catatan customer
                <textarea name="customer_note" placeholder="Catatan tambahan sebelum diskusi WhatsApp"></textarea>
            </label>
            <button class="button primary full" type="submit">Kirim Pesanan ke WhatsApp</button>
        </form>
    </section>
</main>
