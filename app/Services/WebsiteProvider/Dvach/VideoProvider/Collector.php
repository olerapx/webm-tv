<?php
declare(strict_types=1);

namespace App\Services\WebsiteProvider\Dvach\VideoProvider;

class Collector
{
    const MAX_TOTAL_REQUESTS = 20;
    const PARALLEL = 3;

    const API_WEBM = 6;
    const API_MP4 = 10;

    private \App\Services\Http $http;
    private \App\Services\Video\HashChecker $hashChecker;

    public function __construct(
        \App\Services\Http $http,
        \App\Services\Video\HashChecker $hashChecker
    ) {
        $this->http = $http;
        $this->hashChecker = $hashChecker;
    }

    /**
     * @return \App\Contracts\Video[]
     */
    public function collect(string $board, array $threadIds, int $count, array $playlistHashes): array
    {
        if (!$threadIds || !$count) {
            return [];
        }

        $playlistHashes = array_flip($playlistHashes);
        $threadIds = array_slice($threadIds, 0, self::MAX_TOTAL_REQUESTS);

        $result = [];

        foreach (array_chunk($threadIds, self::PARALLEL) as $chunk) {
            $responses = \GuzzleHttp\Promise\Utils::unwrap($this->getRequestBatch($board, $chunk));

            foreach ($responses as $response) {
                $posts = $response['threads'][0]['posts'] ?? [];

                foreach ($this->videosFromPosts($posts) as $video) {
                    if ($this->hashChecker->checkUnique($video, $playlistHashes)) {
                        $result[] = $video;
                    }

                    if (count($result) == $count) {
                        return \App\Services\Video\Sorter::sort($result);
                    }
                }
            }
        }

        return \App\Services\Video\Sorter::sort($result);
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
                    \App\Models\Video::URL        => Url::url($file['path']),
                    \App\Models\Video::NAME       => $file['name'],
                    \App\Models\Video::HASH       => $file['md5'],
                    \App\Models\Video::TYPE       => $videoType,
                    \App\Models\Video::THUMBNAIL  => $thumbnail,
                    \App\Models\Video::SORT_ORDER => (int) $file['name']
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
}
