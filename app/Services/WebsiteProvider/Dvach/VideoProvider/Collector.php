<?php
declare(strict_types=1);

namespace App\Services\WebsiteProvider\Dvach\VideoProvider;

use GuzzleHttp\Promise\PromiseInterface;

class Collector
{
    const MAX_TOTAL_REQUESTS = 20;
    const PARALLEL = 5;

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

        $this->hashChecker->setPlaylist($playlistHashes);
        $threadIds = array_slice($threadIds, 0, self::MAX_TOTAL_REQUESTS);

        $result = [];

        foreach (array_chunk($threadIds, self::PARALLEL) as $chunk) {
            $result += $this->getVideosChunk($board, $chunk, $count);

            if (count($result) == $count) {
                return \App\Services\Video\Sorter::sort($result);
            }
        }

        return \App\Services\Video\Sorter::sort($result);
    }

    private function getVideosChunk(string $board, array $chunk, int $count): array
    {
        $result = [];

        $promises = $this->getRequestBatch($board, $chunk);
        $promisesLeft = count($promises);

        \GuzzleHttp\Promise\Each::of(
            $promises,
            function ($value, $i, PromiseInterface $aggregate) use (&$result, $count, &$promisesLeft) {
                if (\GuzzleHttp\Promise\Is::settled($aggregate)) {
                    return;
                }

                foreach (Extractor::extract($value) as $video) {
                    if ($this->hashChecker->checkUnique($video)) {
                        $result[] = $video;
                    }

                    if (count($result) == $count) {
                        $aggregate->resolve($result);
                        return;
                    }
                }

                $promisesLeft --;
                if (!$promisesLeft) {
                    $aggregate->resolve($result);
                }
            }
        )->wait();

        return $result;
    }

    /**
     * @return PromiseInterface[]
     */
    private function getRequestBatch(string $board, array $threadIds): array
    {
        return array_map(function ($id) use ($board) {
            return $this->http->json(Url::url("{$board}/res/{$id}.json"));
        }, $threadIds);
    }
}
