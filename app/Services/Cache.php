<?php
declare(strict_types=1);

namespace App\Services;

class Cache
{
    const PREFIX = 'webm_tv_';

    private array $cache = [];

    public function get(string $providerId, string $key)
    {
        $cacheKey = self::PREFIX . $providerId . '_' . $key;

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
        $cacheKey = self::PREFIX . $providerId . '_' . $key;

        $this->cache[$cacheKey] = $data;
        \Illuminate\Support\Facades\Cache::put($cacheKey, $data, $ttl);
    }
}
