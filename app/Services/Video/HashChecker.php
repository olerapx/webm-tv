<?php
declare(strict_types=1);

namespace App\Services\Video;

class HashChecker
{
    private const int HISTORY_CHECK_LIMIT = 50000;

    private array $hashed = [];
    private array $plain = [];
    private array $historyHashes = [];

    public function __construct(private readonly array $playlistHashes, string $website)
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        if (!$user) {
            return;
        }

        $history = \App\Models\WatchHistory\Video::search()
            ->where('user', $user->id)
            ->where('website', $website)
            ->orderBy(\App\Models\WatchHistory\Video::CREATED_TIMESTAMP, 'desc')
            ->options(['attributesToRetrieve' => ['hash', 'url_hash']])
            ->take(self::HISTORY_CHECK_LIMIT)
            ->raw();

        $this->historyHashes = array_flip(array_filter(array_merge(
            array_column($history['hits'] ?? [], 'hash'),
            array_column($history['hits'] ?? [], 'url_hash')
        )));
    }

    public function checkUnique(\App\Contracts\Video $video): bool
    {
        $hasHashed = $hasPlain = true;
        [$hash, $urlHash] = [$video->getHash(), $video->getUrlHash()];

        if ($hash !== null && !isset($this->hashed[$hash])
            && !isset($this->playlistHashes[$hash])
            && !isset($this->historyHashes[$hash])) {
            $hasHashed = false;
            $this->hashed[$video->getHash()] = $video;
        }

        if (!isset($this->plain[$urlHash])
            && !isset($this->playlistHashes[$urlHash])
            && !isset($this->historyHashes[$urlHash])) {
            $hasPlain = false;
            $this->plain[$video->getUrlHash()] = $video;
        }

        return !$hasHashed && !$hasPlain;
    }
}
