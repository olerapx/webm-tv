<?php
declare(strict_types=1);

namespace App\Models;

class Breadcrumbs
{
    private array $callbacks = [];
    private ?array $route = null;

    private \Illuminate\Routing\Router $router;
    private BreadcrumbGenerator $breadcrumbGenerator;

    public function __construct(\Illuminate\Routing\Router $router, BreadcrumbGenerator $breadcrumbGenerator)
    {
        $this->router = $router;
        $this->breadcrumbGenerator = $breadcrumbGenerator;
    }

    public function for(string $name, callable $callback): void
    {
        if (isset($this->callbacks[$name])) {
            return;
        }

        $this->callbacks[$name] = $callback;
    }

    public function generate(): \Illuminate\Support\Collection
    {
        try {
            [$name, $params] = $this->getCurrentRoute();
        } catch (\App\Exceptions\UnnamedRouteException $e) {
            return new \Illuminate\Support\Collection();
        }

        try {
            return $this->breadcrumbGenerator->generate($this->callbacks, $name, $params);
        } catch (\Exception $e) {
            return new \Illuminate\Support\Collection();
        }
    }

    private function getCurrentRoute(): array
    {
        $route = $this->router->current();

        if ($route === null) {
            return ['errors.404', []];
        }

        $name = $route->getName();

        if ($name === null) {
            throw new \App\Exceptions\UnnamedRouteException($route);
        }

        $params = array_values(array_map(function ($parameterName) use ($route) {
            return $route->parameter($parameterName);
        }, $route->parameterNames()));

        return [$name, $params];
    }
}
