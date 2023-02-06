<?php
declare(strict_types=1);

namespace App\Models;

class Meta
{
    private array $breadcrumbCallbacks = [];
    private array $metaCallbacks = [];

    private \Illuminate\Routing\Router $router;
    private \App\Models\Meta\BreadcrumbGenerator $breadcrumbGenerator;

    public function __construct(\Illuminate\Routing\Router $router, \App\Models\Meta\BreadcrumbGenerator $breadcrumbGenerator)
    {
        $this->router = $router;
        $this->breadcrumbGenerator = $breadcrumbGenerator;
    }

    public function for(string $name, ?callable $breadcrumbFn = null, ?callable $metaFn = null): void
    {
        if ($breadcrumbFn) {
            $this->breadcrumbCallbacks[$name] = $breadcrumbFn;
        }

        if ($metaFn) {
            $this->metaCallbacks[$name] = $metaFn;
        }
    }

    public function breadcrumbs(): \Illuminate\Support\Collection
    {
        try {
            [$name, $params] = $this->getCurrentRoute();
        } catch (\App\Exceptions\UnnamedRouteException $e) {
            return new \Illuminate\Support\Collection();
        }

        try {
            return $this->breadcrumbGenerator->generate($this->breadcrumbCallbacks, $name, $params);
        } catch (\Exception $e) {
            return new \Illuminate\Support\Collection();
        }
    }

    public function metaDescription(): string
    {
        try {
            [$name, $params] = $this->getCurrentRoute();
        } catch (\App\Exceptions\UnnamedRouteException $e) {
            return config('app.name');
        }

        try {
            if (!isset($this->metaCallbacks[$name])) {
                return config('app.name');
            }

            return $this->metaCallbacks[$name](...$params)['desc'] ?? config('app.name');
        } catch (\Exception $e) {
            return config('app.name');
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
