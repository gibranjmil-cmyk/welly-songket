<?php

declare(strict_types=1);

namespace WellySongket\Core;

use RuntimeException;

final class Router
{
    /**
     * @var Route[]
     */
    private array $routes = [];

    public function get(
        string $uri,
        string $controller,
        string $action,
        ?string $name = null
    ): void {
        $this->add('GET', $uri, $controller, $action, $name);
    }

    public function post(
        string $uri,
        string $controller,
        string $action,
        ?string $name = null
    ): void {
        $this->add('POST', $uri, $controller, $action, $name);
    }

    private function add(
        string $method,
        string $uri,
        string $controller,
        string $action,
        ?string $name
    ): void {

        $this->routes[] = new Route(
            $method,
            '/' . trim($uri, '/'),
            $controller,
            $action,
            $name
        );
    }

    public function dispatch(Request $request): mixed
    {
        $uri = $this->normalizeUri($request->uri());
        $method = $request->method() === 'HEAD' ? 'GET' : $request->method();

        foreach ($this->routes as $route) {

            if (
                $route->method === $method
                && $route->uri === $uri
            ) {

                $controller = new $route->controller();

                return $controller->{$route->action}();
            }
        }

        throw new RuntimeException(
            'Route not found: ' . $method . ' ' . $uri
        );
    }

    /**
     * Normalize URI: lowercase, remove trailing slash (except root).
     */
    private function normalizeUri(string $uri): string
    {
        $uri = '/' . trim($uri, '/');

        // Remove trailing slash except for root
        if ($uri !== '/' && str_ends_with($uri, '/')) {
            $uri = rtrim($uri, '/');
        }

        return $uri;
    }
}
