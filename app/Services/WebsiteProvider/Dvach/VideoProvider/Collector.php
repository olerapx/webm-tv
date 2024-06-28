<?php
declare(strict_types=1);

namespace App\Services\WebsiteProvider\Dvach\VideoProvider;

use GuzzleHttp\Promise\PromiseInterface;

readonly class Collector
{
    private const int MAX_TOTAL_REQUESTS = 100;
    private const int PARALLEL = 5;

    private const string COOKIE = 'usercode_auth';

    public function __construct(
        private \App\Services\Http $http
    ) {

    }

    /**
     * @return \App\Contracts\Video[]
     */
    public function collect(\App\Contracts\Video\FetchRequest $request, array $threadIds): array
    {
        if (!$threadIds || !$request->getCount()) {
            return [];
        }

        $hashChecker = \Illuminate\Support\Facades\App::make(
            \App\Services\Video\HashChecker::class,
            ['playlistHashes' => $request->getPlaylistHashes()]
        );

        $threadIds = array_slice($threadIds, 0, self::MAX_TOTAL_REQUESTS);
        $result = [];

        foreach (array_chunk($threadIds, self::PARALLEL) as $chunk) {
            $result += $this->getVideosChunk($request, $chunk, $hashChecker);

            if (count($result) == $request->getCount()) {
                return \App\Services\Video\Sorter::sort($result);
            }
        }

        return \App\Services\Video\Sorter::sort($result);
    }

    private function getVideosChunk(
        \App\Contracts\Video\FetchRequest $request,
        array $chunk,
        \App\Services\Video\HashChecker $hashChecker
    ): array {
        $result = [];

        $promises = $this->getRequestBatch($request, $chunk);
        $promisesLeft = count($promises);

        \GuzzleHttp\Promise\Each::of(
            $promises,
            function ($value, $i, PromiseInterface $aggregate) use (&$result, $request, &$promisesLeft, $hashChecker) {
                if (\GuzzleHttp\Promise\Is::settled($aggregate)) {
                    return;
                }

                foreach (Extractor::extract($value) as $video) {
                    if ($hashChecker->checkUnique($video)) {
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
