<?php

declare(strict_types=1);

namespace WellySongket\Controllers\Admin;

use WellySongket\Core\Controller;
use WellySongket\Models\Admin;

final class AuthController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->startSession();
    }

    public function login(): never
    {
        if (($_SESSION['admin_logged_in'] ?? false) === true) {
            $this->redirect(url('/admin/dashboard'));
        }

        $this->render('admin/login', [
            'message' => (string) $this->request->query('message', ''),
            'status'  => (string) $this->request->query('status', ''),
        ], 'admin/guest');
    }

    public function authenticate(): never
    {
        if (!csrf_verify()) {
            $this->redirect(url('/admin/login?message=Request+tidak+valid&status=error'));
        }

        $username = trim((string) $this->request->post('username', 'admin'));
        $password = (string) $this->request->post('password');

        // Try DB first
        try {
            $admin = Admin::findByUsername($username);
            $valid = $admin && Admin::verifyPassword($password, $admin['password']);
        } catch (\Throwable) {
            // DB not available — fall back to .env ADMIN_PASSWORD
            $stored = (string) env('ADMIN_PASSWORD', 'admin123');
            $valid  = str_starts_with($stored, '$2y$')
                ? password_verify($password, $stored)
                : hash_equals($stored, $password);
        }

        if ($valid) {
            session_regenerate_id(true);
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username']  = $username;
            $this->redirect(url('/admin/dashboard'));
        }

        $this->redirect(url('/admin/login?message=Username+atau+password+salah&status=error'));
    }

    public function logout(): never
    {
        if (!csrf_verify()) {
            $this->redirect(url('/admin/login'));
        }

        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $p = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
        }
        session_destroy();

        $this->redirect(url('/admin/login?message=Berhasil+logout&status=success'));
    }

    private function startSession(): void
    {
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
    }
}
