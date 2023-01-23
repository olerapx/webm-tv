<?php
declare(strict_types=1);

namespace App\Models;

class BreadcrumbGenerator
{
    private ?\Illuminate\Support\Collection $path = null;

    private array $callbacks = [];

    public function generate(array $callbacks, string $name, array $params): \Illuminate\Support\Collection
    {
        $this->path = new \Illuminate\Support\Collection();
        $this->callbacks = $callbacks;

        if (!isset($this->callbacks[$name])) {
            throw new \Exception($name);
        }

        $this->callbacks[$name]($this, ...$params);

        return $this->path;
    }

    public function push(string $title, ?string $url = null, array $data = []): self
    {
        $this->path->push(array_merge($data, compact('title', 'url')));
        return $this;
    }
}
