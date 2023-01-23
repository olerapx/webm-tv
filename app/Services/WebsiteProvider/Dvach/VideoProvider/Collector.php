<?php
declare(strict_types=1);

namespace App\Services\WebsiteProvider\Dvach\VideoProvider;

class Collector
{
    const MAX_TOTAL_REQUESTS = 20;
    const PARALLEL = 5;

    const API_WEBM = 6;
    const API_MP4 = 10;

    private array $hashed = [];
    private array $plain = [];

    private \App\Services\Http $http;

    public function __construct(
        \App\Services\Http $http
    ) {
        $this->http = $http;
    }

    /**
     * @return \App\Contracts\Video[]
     */
    public function collect(string $board, array $threadIds, int $count, array $hashes): array
    {
        if (!$threadIds || !$count) {
            return [];
        }

        $hashes = array_flip($hashes);
        $threadIds = array_slice($threadIds, 0, self::MAX_TOTAL_REQUESTS);

        $result = [];

        foreach (array_chunk($threadIds, self::PARALLEL) as $chunk) {
            $responses = \GuzzleHttp\Promise\Utils::unwrap($this->getRequestBatch($board, $chunk));

            foreach ($responses as $response) {
                $posts = $response['threads'][0]['posts'] ?? [];

                foreach ($this->videosFromPosts($posts) as $video) {
                    if ($this->checkHashUnique($video, $hashes)) {
                        $result[] = $video;
                    }

                    if (count($result) == $count) {
                        return $result;
                    }
                }
            }
        }

        return $result;
    }

    /**
     * @return \GuzzleHttp\Promise\PromiseInterface[]
     */
    private function getRequestBatch(string $board, array $threadIds): array
    {
        $result = [];

        foreach ($threadIds as $id) {
            $result[] = $this->http->json(Url::url("{$board}/res/{$id}.json"));
        }

        return $result;
    }

    private function videosFromPosts(array $posts): \Generator
    {
        foreach ($posts as $post) {
            foreach ($post['files'] ?? [] as $file) {
                $videoType = $this->apiToVideoType((int) $file['type']);

                if (!$videoType) {
                    continue;
                }

                $thumbnail = isset($file['thumbnail']) ? Url::url($file['thumbnail']) : null;

                yield new \App\Models\Video([
                    \App\Models\Video::URL       => Url::url($file['path']),
                    \App\Models\Video::NAME      => $file['name'],
                    \App\Models\Video::HASH      => $file['md5'],
                    \App\Models\Video::TYPE      => $videoType,
                    \App\Models\Video::THUMBNAIL => $thumbnail
                ]);
            }
        }
    }

    private function apiToVideoType(int $type): ?\App\Enums\VideoType
    {
        return match ($type) {
            self::API_WEBM => \App\Enums\VideoType::WEBM,
            self::API_MP4 => \App\Enums\VideoType::MP4,
            default => null
        };
    }

    private function checkHashUnique(\App\Contracts\Video $video, array $hashes): bool
    {
        $hasHashed = $hasPlain = true;
        [$hash, $urlHash] = [$video->getHash(), $video->getUrlHash()];

        if ($hash !== null && !isset($this->hashed[$hash]) && !isset($hashes[$hash])) {
            $hasHashed = false;
            $this->hashed[$video->getHash()] = $video;
        }

        if (!isset($this->plain[$urlHash]) && !isset($hashes[$urlHash])) {
            $hasPlain = false;
            $this->plain[$video->getUrlHash()] = $video;
        }

        return !$hasHashed && !$hasPlain;
    }
}
