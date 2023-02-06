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
            return $this->breadcrumbGenerator->generate($this->breadcrumbCallbacks, $name, $params);
        } catch (\Exception $e) {
            return new \Illuminate\Support\Collection();
        }
    }

    public function title(): string
    {
        return $this->generateMeta()['title'] ?? config('app.name');
    }

    public function description(): string
    {
        return $this->generateMeta()['desc'] ?? config('app.name');
    }

    private function generateMeta(): array
    {
        try {
            [$name, $params] = $this->getCurrentRoute();

            if (!isset($this->metaCallbacks[$name])) {
                return [];
            }

            return $this->metaCallbacks[$name](...$params);
        } catch (\Exception $e) {
            return [];
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
