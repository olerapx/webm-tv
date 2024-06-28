<?php
declare(strict_types=1);

namespace App\Services\WebsiteProvider\Dvach;

use App\Services\Http;
use App\Services\WebsiteProvider\Dvach\VideoProvider\Url;

readonly class VideoProvider implements \App\Contracts\Website\VideoProvider
{
    private const string ID = \App\Enums\Website::Dvach->value;
    private const int MAX_VIDEOS = 20;

    public function __construct(
        private Http $http,
        private \App\Services\Cache $cache,
        private \App\Services\WebsiteProvider\Dvach\VideoProvider\Collector $collector
    ) {

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
            $json = $this->http->json(Url::url('api/mobile/v2/boards'))->wait();

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

    public function getVideos(\App\Contracts\Video\FetchRequest $fetchRequest): array
    {
        if ($fetchRequest->getCount() === null
            || $fetchRequest->getCount() < 1
            || $fetchRequest->getCount() > self::MAX_VIDEOS) {
            $fetchRequest->setCount(self::MAX_VIDEOS);
        }

        try {
            $ids = $this->getThreadIds($fetchRequest->getBoard());
            return $this->collector->collect($fetchRequest, $ids);
        } catch (\App\Exceptions\PrivateBoardException $e) {
            throw $e;
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error($e->getMessage());
            return [];
        }
    }

    private function getThreadIds(string $board): array
    {
        $threads = $this->http->json(Url::url("$board/catalog.json"))->wait()['threads'] ?? [];

        $result = [];
        foreach ($threads as $thread) {
            $result[] = (int) $thread['num'];
        }

        return $result;
    }
}
