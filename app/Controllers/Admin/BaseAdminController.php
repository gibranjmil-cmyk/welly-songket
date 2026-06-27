<?php

declare(strict_types=1);

namespace WellySongket\Controllers\Admin;

use WellySongket\Core\Controller;

abstract class BaseAdminController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        if (session_status() !== PHP_SESSION_ACTIVE) {
            $name     = (string) env('SESSION_NAME', 'WELLY_SESSION');
            $lifetime = (int) env('SESSION_LIFETIME', 120) * 60;
            session_name($name);
            ini_set('session.gc_maxlifetime', (string) $lifetime);
            session_set_cookie_params([
                'lifetime' => $lifetime,
                'path'     => '/',
                'secure'   => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
                'httponly' => true,
                'samesite' => 'Lax',
            ]);
            session_start();
        }

        $this->guard();
    }

    protected function guard(): void
    {
        if (($_SESSION['admin_logged_in'] ?? false) !== true) {
            $this->redirect(url('/admin/login'));
        }
    }

    protected function back(string $message = '', string $status = 'success'): never
    {
        $ref = $_SERVER['HTTP_REFERER'] ?? url('/admin/dashboard');
        if ($message !== '') {
            $sep = str_contains($ref, '?') ? '&' : '?';
            $ref = $ref . $sep . 'message=' . urlencode($message) . '&status=' . $status;
        }
        $this->redirect($ref);
    }

    protected function toAdmin(string $message = '', string $status = 'success'): never
    {
        $qs = $message !== ''
            ? '?message=' . urlencode($message) . '&status=' . $status
            : '';
        $this->redirect(url('/admin/dashboard' . $qs));
    }

    protected function requireCsrf(): void
    {
        if (!csrf_verify()) {
            $this->toAdmin('Request tidak valid (CSRF)', 'error');
        }
    }
}
