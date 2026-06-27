<?php

declare(strict_types=1);

use WellySongket\Core\Env;

if (!function_exists('env')) {

    function env(string $key, mixed $default = null): mixed
    {
        return Env::get($key, $default);
    }

}

if (!function_exists('e')) {

    function e(mixed $value): string
    {
        return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
    }

}

if (!function_exists('_detect_base_url')) {

    /**
     * Auto-detect base URL from $_SERVER superglobals.
     * Works regardless of subfolder depth or domain.
     * e.g. http://localhost/welly_songket/public
     *      http://localhost/welly-fixed/public
     *      https://wellysongket.com
     */
    function _detect_base_url(): string
    {
        $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $host   = $_SERVER['HTTP_HOST'] ?? 'localhost';

        // SCRIPT_NAME = /welly_songket/public/index.php  → strip index.php
        $scriptDir = rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? ''), '/\\');

        return $scheme . '://' . $host . $scriptDir;
    }

}

if (!function_exists('url')) {

    function url(string $path = ''): string
    {
        $configured = rtrim((string) env('APP_URL', ''), '/');

        // Fall back to auto-detection when APP_URL is missing or corrupt
        $base = ($configured !== '') ? $configured : _detect_base_url();

        $path = '/' . ltrim($path, '/');

        return $base . $path;
    }

}

if (!function_exists('asset')) {

    function asset(string $path): string
    {
        return url($path);
    }

}

if (!function_exists('csrf_token')) {

    function csrf_token(): string
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            return '';
        }
        if (empty($_SESSION['_csrf_token'])) {
            $_SESSION['_csrf_token'] = bin2hex(random_bytes(32));
        }
        return (string) $_SESSION['_csrf_token'];
    }

}

if (!function_exists('csrf_field')) {

    function csrf_field(): string
    {
        $token = csrf_token();
        if ($token === '') {
            return '';
        }
        return '<input type="hidden" name="_csrf_token" value="' . htmlspecialchars($token, ENT_QUOTES, 'UTF-8') . '">';
    }

}

if (!function_exists('csrf_verify')) {

    function csrf_verify(): bool
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            return false;
        }
        $expected = (string) ($_SESSION['_csrf_token'] ?? '');
        $given    = (string) ($_POST['_csrf_token'] ?? '');
        if ($expected === '' || $given === '') {
            return false;
        }
        return hash_equals($expected, $given);
    }

}
