<?php
declare(strict_types=1);

namespace App\Services\WebsiteProvider\Dvach\VideoProvider;

use GuzzleHttp\Promise\PromiseInterface;

class Collector
{
    const MAX_TOTAL_REQUESTS = 20;
    const PARALLEL = 5;

    const COOKIE = 'usercode_auth';

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
    public function collect(\App\Contracts\Video\FetchRequest $request, array $threadIds): array
    {
        if (!$threadIds || !$request->getCount()) {
            return [];
        }

        $this->hashChecker->setPlaylist($request->getPlaylistHashes());
        $threadIds = array_slice($threadIds, 0, self::MAX_TOTAL_REQUESTS);

        $result = [];

        foreach (array_chunk($threadIds, self::PARALLEL) as $chunk) {
            $result += $this->getVideosChunk($request, $chunk);

            if (count($result) == $request->getCount()) {
                return \App\Services\Video\Sorter::sort($result);
            }
        }

        return \App\Services\Video\Sorter::sort($result);
    }

    private function getVideosChunk(\App\Contracts\Video\FetchRequest $request, array $chunk): array
    {
        $result = [];

        $promises = $this->getRequestBatch($request, $chunk);
        $promisesLeft = count($promises);

        \GuzzleHttp\Promise\Each::of(
            $promises,
            function ($value, $i, PromiseInterface $aggregate) use (&$result, $request, &$promisesLeft) {
                if (\GuzzleHttp\Promise\Is::settled($aggregate)) {
                    return;
                }

                foreach (Extractor::extract($value) as $video) {
                    if ($this->hashChecker->checkUnique($video)) {
                        $result[] = $video;
                    }

                    if (count($result) == $request->getCount()) {
                        $aggregate->resolve($result);
                        return;
                    }
                }

                $promisesLeft --;
                if (!$promisesLeft) {
                    $aggregate->resolve($result);
                }
            },
            function ($value, $key, PromiseInterface $aggregate) {
                if (!$value instanceof \GuzzleHttp\Exception\ServerException) {
                    return;
                }

                if ($value->getCode() === 500 && str_contains($value->getMessage(), 'Not found')) {
                    $aggregate->resolve([]);
                    throw new \App\Exceptions\PrivateBoardException();
                }
            },
        )->wait();

        return $result;
    }

    /**
     * @return PromiseInterface[]
     */
    private function getRequestBatch(\App\Contracts\Video\FetchRequest $request, array $threadIds): array
    {
        return array_map(function ($id) use ($request) {
            return $this->http->json(Url::url("{$request->getBoard()}/res/{$id}.json"), [
                self::COOKIE => $request->getAccessCode()
            ]);
        }, $threadIds);
    }
}
