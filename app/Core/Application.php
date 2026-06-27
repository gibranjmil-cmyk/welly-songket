<?php

declare(strict_types=1);

namespace WellySongket\Core;

final class Application
{
    public function __construct(
        private readonly string $basePath
    ) {
    }

    public function run(): void
    {
        Env::load(
            $this->basePath . '/.env'
        );

        date_default_timezone_set(
            env('APP_TIMEZONE', 'Asia/Jakarta')
        );

        $router = new Router();

        require BASE_PATH . '/app/Routes/web.php';
        require BASE_PATH . '/app/Routes/admin.php';
        require BASE_PATH . '/app/Routes/api.php';

        try {
            $router->dispatch(
                new Request()
            );
        } catch (\RuntimeException $e) {
            // Route not found → 404
            if (str_contains($e->getMessage(), 'Route not found')) {
                http_response_code(404);
                echo '<!DOCTYPE html><html lang="id"><head><meta charset="utf-8"><title>404 — Halaman Tidak Ditemukan</title></head>'
                    . '<body style="font-family:sans-serif;text-align:center;padding:80px 20px">'
                    . '<h1>404</h1><p>Halaman tidak ditemukan.</p>'
                    . '<a href="' . url('/') . '">Kembali ke halaman utama</a>'
                    . '</body></html>';
                exit;
            }
            // Other runtime errors
            if ((bool) env('APP_DEBUG', false)) {
                http_response_code(500);
                echo '<pre>' . htmlspecialchars($e->getMessage() . "\n" . $e->getTraceAsString()) . '</pre>';
                exit;
            }
            http_response_code(500);
            echo '<!DOCTYPE html><html lang="id"><head><meta charset="utf-8"><title>500 — Server Error</title></head>'
                . '<body style="font-family:sans-serif;text-align:center;padding:80px 20px">'
                . '<h1>500</h1><p>Terjadi kesalahan server.</p>'
                . '</body></html>';
            exit;
        }
    }
}
