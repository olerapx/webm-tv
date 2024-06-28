<?php
declare(strict_types=1);

namespace App\Models;

class Meta
{
    private array $breadcrumbCallbacks = [];
    private array $metaCallbacks = [];

    public function __construct(
        private readonly \Illuminate\Routing\Router $router,
        private readonly \App\Models\Meta\BreadcrumbGenerator $breadcrumbGenerator
    ) {

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

    /**
     * @return array{title: string, desc:string}
     */
    public function metadata(): array
    {
        $meta = $this->doGetMetadata();

        return [
            'title' => $meta['title'] ?? config('app.name'),
            'desc'  => $meta['desc'] ?? config('app.name')
        ];
    }

    private function doGetMetadata(): array
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

        $params = array_values(array_map(fn ($name) => $route->parameter($name), $route->parameterNames()));
        return [$name, $params];
    }
}
