<?php
declare(strict_types=1);

namespace App\Services\WebsiteProvider\Dvach;

use App\Services\Http;
use App\Services\WebsiteProvider\Dvach\VideoProvider\Url;

class VideoProvider implements \App\Contracts\Website\VideoProvider
{
    const ID = 'dvach';

    const MAX_VIDEOS = 20;

    private Http $http;
    private \App\Services\Cache $cache;
    private VideoProvider\Collector $collector;

    public function __construct(
         Http $http,
        \App\Services\Cache $cache,
        \App\Services\WebsiteProvider\Dvach\VideoProvider\Collector $collector
    ) {
        $this->http = $http;
        $this->cache = $cache;
        $this->collector = $collector;
    }

    public function getBoards(): array
    {
        $cached = $this->cache->get(self::ID, 'boards');

        if ($cached !== null) {
            return json_decode($cached, true);
        }

        $result = $this->doGetBoards();

        if ($result) {
            $this->cache->set(self::ID, 'boards', json_encode($result), 24 * 60 * 60);
        }

        return $result;
    }
    private function doGetBoards(): array
    {
        try {
            $json = $this->http->json(Url::url('api/mobile/v2/boards'))->wait(true);

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

    public function getVideos(\App\Contracts\Video\FetchRequest $request): array
    {
        if ($request->getCount() === null || $request->getCount() < 1 || $request->getCount() > self::MAX_VIDEOS) {
            $request->setCount(self::MAX_VIDEOS);
        }

        try {
            $ids = $this->getThreadIds($request->getBoard());
            return $this->collector->collect($request, $ids);
        } catch (\App\Exceptions\PrivateBoardException $e) {
            throw $e;
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error($e->getMessage());
            return [];
        }
    }

    private function getThreadIds(string $board): array
    {
        $threads = $this->http->json(Url::url("$board/catalog.json"))->wait(true)['threads'] ?? [];

        $result = [];
        foreach ($threads as $thread) {
            $result[] = (int) $thread['num'];
        }

        return $result;
    }
}
