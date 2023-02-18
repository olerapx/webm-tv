<?php
declare(strict_types=1);

namespace App\Services\WebsiteProvider\Dvach\VideoProvider;

use App\Services\Video\HashChecker;
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
            HashChecker::class,
            ['playlistHashes' => $request->getPlaylistHashes(), 'website' => $request->getWebsite()]
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
        HashChecker $hashChecker
    ): array {
        $result = [];

        $promises = $this->getRequestBatch($request, $chunk);
        $left = count($promises);

        \GuzzleHttp\Promise\Each::of(
            $promises,
            $this->onSuccess($result, (int) $request->getCount(), $left, $hashChecker),
            $this->onError()
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

    private function onSuccess(array &$result, int $count, int &$left, HashChecker $hashChecker): \Closure
    {
        return function ($value, $i, PromiseInterface $promise) use (&$result, $count, &$left, $hashChecker) {
            if (\GuzzleHttp\Promise\Is::settled($promise)) {
                return;
            }

            foreach (Extractor::extract($value) as $video) {
                if ($hashChecker->checkUnique($video)) {
                    $result[] = $video;
                }

                if (count($result) == $count) {
                    $promise->resolve($result);
                    return;
                }
            }

            $left--;
            if (!$left) {
                $promise->resolve($result);
            }
        };
    }

    private function onError(): \Closure
    {
        return function ($value, $key, PromiseInterface $promise) {
            if (!$value instanceof \GuzzleHttp\Exception\ServerException) {
                return;
            }

            if ($value->getCode() === 500 && str_contains($value->getMessage(), 'Not found')) {
                $promise->resolve([]);
                throw new \App\Exceptions\PrivateBoardException();
            }
        };
    }
}
