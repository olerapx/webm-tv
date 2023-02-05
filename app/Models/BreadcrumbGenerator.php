<?php
declare(strict_types=1);

namespace App\Models;

class BreadcrumbGenerator
{
    private ?\Illuminate\Support\Collection $path = null;

    private array $cache = [];

    private array $callbacks = [];

    public function generate(array $callbacks, string $name, array $params): \Illuminate\Support\Collection
    {
        if (array_key_exists($name, $this->cache)) {
            return $this->cache[$name];
        }

        $this->path = new \Illuminate\Support\Collection();
        $this->callbacks = $callbacks;

        if (!isset($this->callbacks[$name])) {
            throw new \Exception($name);
        }

        $this->callbacks[$name]($this, ...$params);

        return $this->cache[$name] = $this->path;
    }

    public function push(string $title, ?string $url = null, array $data = []): self
    {
        $this->path->push(array_merge($data, compact('title', 'url')));
        return $this;
    }
}
