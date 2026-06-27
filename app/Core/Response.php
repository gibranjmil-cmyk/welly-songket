<?php

declare(strict_types=1);

namespace WellySongket\Core;

final class Response
{
    /**
     * HTTP Status Code
     */
    private int $statusCode = 200;

    /**
     * Response Headers
     *
     * @var array<string, string>
     */
    private array $headers = [];

    /**
     * Set HTTP Status Code
     */
    public function status(int $code): self
    {
        $this->statusCode = $code;

        return $this;
    }

    /**
     * Add Header
     */
    public function header(string $name, string $value): self
    {
        $this->headers[$name] = $value;

        return $this;
    }

    /**
     * Send Headers
     */
    private function sendHeaders(): void
    {
        http_response_code($this->statusCode);

        foreach ($this->headers as $name => $value) {
            header($name . ': ' . $value);
        }
    }

    /**
     * Output HTML
     */
    public function html(string $content): never
    {
        $this->header('Content-Type', 'text/html; charset=UTF-8');

        $this->sendHeaders();

        echo $content;

        exit;
    }

    /**
     * Output JSON
     */
    public function json(array $data): never
    {
        $this->header('Content-Type', 'application/json; charset=UTF-8');

        $this->sendHeaders();

        echo json_encode(
            $data,
            JSON_UNESCAPED_UNICODE
            | JSON_UNESCAPED_SLASHES
            | JSON_PRETTY_PRINT
        );

        exit;
    }

    /**
     * Redirect
     */
    public function redirect(string $url, int $statusCode = 302): never
    {
        $this->status($statusCode);

        header('Location: ' . $url, true, $statusCode);

        exit;
    }

    /**
     * Redirect Back
     */
    public function back(): never
    {
        $url = $_SERVER['HTTP_REFERER'] ?? '/';

        $this->redirect($url);
    }

    /**
     * No Content
     */
    public function noContent(): never
    {
        $this->status(204);

        $this->sendHeaders();

        exit;
    }

    /**
     * 404 Response
     */
    public function notFound(string $message = '404 Not Found'): never
    {
        $this->status(404);

        $this->html($message);
    }

    /**
     * 403 Response
     */
    public function forbidden(string $message = '403 Forbidden'): never
    {
        $this->status(403);

        $this->html($message);
    }

    /**
     * 500 Response
     */
    public function serverError(
        string $message = '500 Internal Server Error'
    ): never {
        $this->status(500);

        $this->html($message);
    }
}