<?php
declare(strict_types=1);

namespace App\Services\Video;

class HashChecker
{
    private array $hashed = [];
    private array $plain = [];

    public function __construct(private readonly array $playlistHashes)
    {

    }

    public function checkUnique(\App\Contracts\Video $video): bool
    {
        $hasHashed = $hasPlain = true;
        [$hash, $urlHash] = [$video->getHash(), $video->getUrlHash()];

        if ($hash !== null && !isset($this->hashed[$hash]) && !isset($this->playlistHashes[$hash])) {
            $hasHashed = false;
            $this->hashed[$video->getHash()] = $video;
        }

        if (!isset($this->plain[$urlHash]) && !isset($this->playlistHashes[$urlHash])) {
            $hasPlain = false;
            $this->plain[$video->getUrlHash()] = $video;
        }

        return !$hasHashed && !$hasPlain;
    }
}
