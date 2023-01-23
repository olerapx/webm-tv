<?php
declare(strict_types=1);

namespace App\Services\WebsiteProvider\Dvach;

use App\Services\Http;

class VideoProvider implements \App\Contracts\Website\VideoProvider
{
    const ID = 'dvach';
    const BASE_URL = 'https://2ch.hk';

    private Http $http;
    private \App\Services\Cache $cache;

    public function __construct(
         Http $http,
        \App\Services\Cache $cache
    ) {
        $this->http = $http;
        $this->cache = $cache;
    }

    public function getBoards(): array
    {
        $cached = $this->cache->get(self::ID, 'boards');

        if ($cached !== null) {
            return json_decode($cached, true);
        }

        $result = $this->doGetBoards();
        $this->cache->set(self::ID, 'boards', json_encode($result), 24 * 60 * 60);

        return $result;
    }

    private function doGetBoards(): array
    {
        try {
            $json = $this->http->json($this->url('api/mobile/v2/boards'));

            $result = [];
            foreach ($json as $row) {
                $result[$row['id']] = $row['name'];
            }

            ksort($result);
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error($e->getMessage());
            return [];
        }

        return $result;
    }

    private function url(string $endpoint): string
    {
        return self::BASE_URL . '/' . $endpoint;
    }
}
