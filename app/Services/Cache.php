<?php
declare(strict_types=1);

namespace App\Services;

class Cache
{
    private const int CACHE_LIMIT = 2;

    private array $cache = [];

    public function get(string $providerId, string $key)
    {
        $cacheKey = $providerId . '_' . $key;

        if (array_key_exists($cacheKey, $this->cache)) {
            return $this->cache;
        }

        $result = \Illuminate\Support\Facades\Cache::get($cacheKey);
        if ($result === null) {
            return null;
        }

        return $this->cache[$cacheKey] = $result;
    }

    public function set(string $providerId, string $key, $data, int $ttl)
    {
        $cacheKey = $providerId . '_' . $key;

        $this->cache[$cacheKey] = $data;
        \Illuminate\Support\Facades\Cache::put($cacheKey, $data, $ttl);

        $this->evict();
    }

    private function evict(): void
    {
        if (count($this->cache) <= self::CACHE_LIMIT) {
            return;
        }

        $this->cache = array_slice($this->cache, -self::CACHE_LIMIT);
    }
}
