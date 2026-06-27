<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welly Songket Admin</title>
    <link href="<?= asset('/assets/css/admin.css') ?>" rel="stylesheet">
</head>
<body>
<header class="admin-header">
    <a class="admin-brand" href="<?= url('/admin/dashboard') ?>">
        <span class="admin-brand-mark">WS</span>
        <span>Welly Songket</span>
    </a>
    <nav class="admin-nav">
        <a href="<?= url('/admin/dashboard') ?>" class="<?= str_contains($_SERVER['REQUEST_URI'] ?? '', '/admin/dashboard') || preg_match('#/admin/?$#', $_SERVER['REQUEST_URI'] ?? '') ? 'active' : '' ?>">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
            Dashboard
        </a>
        <a href="<?= url('/admin/products') ?>" class="<?= str_contains($_SERVER['REQUEST_URI'] ?? '', '/admin/products') ? 'active' : '' ?>">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 7H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
            Produk
        </a>
        <a href="<?= url('/admin/motifs') ?>" class="<?= str_contains($_SERVER['REQUEST_URI'] ?? '', '/admin/motifs') ? 'active' : '' ?>">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M12 2v3M12 19v3M4.22 4.22l2.12 2.12M17.66 17.66l2.12 2.12M2 12h3M19 12h3M4.22 19.78l2.12-2.12M17.66 6.34l2.12-2.12"/></svg>
            Motif
        </a>
        <a href="<?= url('/admin/orders') ?>" class="<?= str_contains($_SERVER['REQUEST_URI'] ?? '', '/admin/orders') ? 'active' : '' ?>">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 17H7A5 5 0 0 1 7 7h2"/><path d="M15 7h2a5 5 0 0 1 0 10h-2"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
            Pesanan
        </a>
        <a href="<?= url('/admin/categories') ?>" class="<?= str_contains($_SERVER['REQUEST_URI'] ?? '', '/admin/categories') ? 'active' : '' ?>">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
            Kategori
        </a>
        <a href="<?= url('/') ?>" target="_blank">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
            Website
        </a>
        <form method="post" action="<?= url('/admin/logout') ?>" style="display:inline">
            <?= csrf_field() ?>
            <button type="submit" class="btn-logout">Logout</button>
        </form>
    </nav>
</header>
<main class="admin-shell">
    <?= $content ?? '' ?>
</main>
</body>
</html>
