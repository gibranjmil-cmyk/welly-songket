<?php

declare(strict_types=1);

namespace WellySongket\Core;

final class Request
{
    private array $get;

    private array $post;

    private array $files;

    private array $server;

    private array $cookies;

    public function __construct()
    {
        $this->get = $_GET;
        $this->post = $_POST;
        $this->files = $_FILES;
        $this->server = $_SERVER;
        $this->cookies = $_COOKIE;
    }

    public function method(): string
    {
        return strtoupper($this->server['REQUEST_METHOD'] ?? 'GET');
    }

    public function uri(): string
    {
        $uri = parse_url(
            $this->server['REQUEST_URI'] ?? '/',
            PHP_URL_PATH
        );

        if ($uri === false || $uri === null) {
            return '/';
        }

        $scriptDir = str_replace('\\', '/', dirname($this->server['SCRIPT_NAME'] ?? ''));

        if ($scriptDir !== '/' && str_starts_with($uri, $scriptDir)) {
            $uri = substr($uri, strlen($scriptDir));
        }

        return '/' . trim($uri, '/');
    }

    public function isGet(): bool
    {
        return $this->method() === 'GET';
    }

    public function isPost(): bool
    {
        return $this->method() === 'POST';
    }

    public function all(): array
    {
        return array_merge($this->get, $this->post);
    }

    public function input(string $key, mixed $default = null): mixed
    {
        return $this->post[$key]
            ?? $this->get[$key]
            ?? $default;
    }

    public function query(string $key, mixed $default = null): mixed
    {
        return $this->get[$key] ?? $default;
    }

    public function post(string $key, mixed $default = null): mixed
    {
        return $this->post[$key] ?? $default;
    }

    public function file(string $key): ?array
    {
        return $this->files[$key] ?? null;
    }

    public function has(string $key): bool
    {
        return isset($this->post[$key]) || isset($this->get[$key]);
    }

    public function filled(string $key): bool
    {
        if (!$this->has($key)) {
            return false;
        }

        return trim((string) $this->input($key)) !== '';
    }

    public function header(string $key): ?string
    {
        $key = 'HTTP_' . strtoupper(str_replace('-', '_', $key));

        return $this->server[$key] ?? null;
    }

    public function ip(): string
    {
        return $this->server['REMOTE_ADDR'] ?? '';
    }

    public function userAgent(): string
    {
        return $this->server['HTTP_USER_AGENT'] ?? '';
    }

    public function ajax(): bool
    {
        return $this->header('X-Requested-With') === 'XMLHttpRequest';
    }
}
