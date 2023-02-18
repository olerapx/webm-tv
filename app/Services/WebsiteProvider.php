<?php
declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\App;

class WebsiteProvider implements \App\Contracts\WebsiteProvider
{
    private array $cache = [];

    public function getAll(): array
    {
        if ($this->cache) {
            return $this->cache;
        }

        return $this->cache = [
            \App\Enums\Website::Dvach->value => App::make(\App\Services\WebsiteProvider\Dvach::class)
        ];
    }

    public function getAllowedDomains(): array
    {
        $result = [];

        foreach ($this->getAll() as $website) {
            $result[] = $website->getAllowedDomains();
        }

        return array_unique(array_merge(...$result));
    }
}
