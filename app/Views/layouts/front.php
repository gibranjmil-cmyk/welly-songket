<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e(env('APP_NAME', 'Welly Songket')) ?></title>
    <meta name="description" content="Website preorder Welly Songket Pandai Sikek. Pesan produk songket custom sesuai ukuran, motif, dan kebutuhan customer.">
    <link rel="stylesheet" href="<?= asset('/assets/css/site.css') ?>">
</head>
<body>
    <?= $content ?? '' ?>
    <script src="<?= asset('/assets/js/site.js') ?>"></script>
</body>
</html>
