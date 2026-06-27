<div class="ws-auth-shell">
    <aside class="ws-auth-brand" aria-hidden="true">
        <div class="ws-auth-brand-top">
            <a class="ws-auth-wordmark" href="<?= url('/') ?>">
                Welly Songket
                <small>Pandai Sikek</small>
            </a>
            <p class="ws-auth-tagline">
                Studio songket custom dengan sistem preorder. Kelola produk, motif, pesanan, dan media katalog dari satu dashboard.
            </p>
        </div>
        <div class="ws-auth-brand-bottom">
            <div class="ws-auth-brand-meta">
                <span>⚡</span>
                <span>Akses khusus admin</span>
            </div>
        </div>
    </aside>

    <main class="ws-auth-form-col">
        <div class="ws-auth-card">
            <a class="ws-auth-mobile-brand" href="<?= url('/') ?>">Welly Songket</a>

            <p class="ws-eyebrow">Admin</p>
            <h1 class="ws-heading">Masuk Dashboard</h1>
            <p class="ws-auth-intro">Kelola produk, motif, pesanan, foto, dan video.</p>

            <?php if (($message ?? '') !== ''): ?>
                <div class="alert <?= ($status ?? '') === 'error' ? 'alert-danger' : 'alert-success' ?>" role="alert">
                    <?= e($message) ?>
                </div>
            <?php endif; ?>

            <form method="post" action="<?= url('/admin/login') ?>" novalidate>
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label class="form-label" for="admin-username">Username</label>
                    <input
                        id="admin-username"
                        name="username"
                        type="text"
                        class="form-control"
                        autocomplete="username"
                        placeholder="admin"
                        value="admin"
                        required
                        autofocus
                    >
                </div>
                <div class="mb-3">
                    <label class="form-label" for="admin-password">Password</label>
                    <div class="input-group">
                        <input
                            id="admin-password"
                            name="password"
                            type="password"
                            class="form-control"
                            autocomplete="current-password"
                            placeholder="Masukkan password"
                            required
                        >
                        <button class="btn btn-outline-secondary ws-password-toggle" type="button" data-password-toggle="admin-password" aria-label="Tampilkan password">
                            👁
                        </button>
                    </div>
                </div>
                <button class="btn btn-primary w-100" type="submit">Masuk</button>
            </form>

            <a class="ws-auth-back" href="<?= url('/') ?>">← Kembali ke website</a>
            <p class="ws-auth-footer-note">&copy; <?= date('Y') ?> Welly Songket. Akses internal admin.</p>
        </div>
    </main>
</div>
