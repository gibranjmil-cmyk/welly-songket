<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title><?= e($title ?? 'Masuk Admin') ?> · Welly Songket</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@1.4.0/dist/css/tabler.min.css">
    <link rel="stylesheet" href="<?= asset('/assets/css/theme.css') ?>">
    <link rel="stylesheet" href="<?= asset('/assets/css/admin-auth.css') ?>">
</head>
<body>
    <?= $content ?? '' ?>

    <script src="https://unpkg.com/lucide@latest" defer></script>
    <script src="<?= asset('/assets/js/admin.js') ?>" defer></script>
</body>
</html>
