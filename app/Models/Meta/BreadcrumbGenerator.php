<?php
declare(strict_types=1);

namespace App\Models\Meta;

class BreadcrumbGenerator
{
    private ?\Illuminate\Support\Collection $path = null;

    public function generate(array $callbacks, string $name, array $params): \Illuminate\Support\Collection
    {
        $this->path = new \Illuminate\Support\Collection();

        if (!isset($callbacks[$name])) {
            throw new \Exception($name);
        }

        $callbacks[$name]($this, ...$params);
        return $this->path;
    }

    public function push(string $title, ?string $url = null, array $data = []): self
    {
        $this->path->push(array_merge($data, compact('title', 'url')));
        return $this;
    }
}
