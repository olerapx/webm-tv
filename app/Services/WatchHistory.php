<?php
declare(strict_types=1);

namespace App\Services;

class WatchHistory
{
    const MAX_VIDEOS_TO_SAVE = 10;

    public function add(
        array $videos,
        string $website,
        string $board,
        \Illuminate\Contracts\Auth\Authenticatable $user): void {
        $history = array_map(
            fn(\App\Contracts\Video $video) => $this->from($video, $website, $board, $user),
            $videos
        );

        $history = array_slice($history, 0, self::MAX_VIDEOS_TO_SAVE);
        foreach ($history as $video) {
            $video->save();
        }
    }

    private function from(
        \App\Contracts\Video $video,
        string $website,
        string $board,
        \Illuminate\Contracts\Auth\Authenticatable $user
    ): \App\Models\WatchHistory\Video {
        // TODO: DURING SEARCH, USE ONLY WEBSITE TO FILTER
        $data = [
            'id'               => \Symfony\Component\Uid\Ulid::generate(),
            'user'             => $user->id,
            'website'          => $website,
            'board'            => $board,
            'url'              => $video->getUrl(),
            'name'             => $video->getName(),
            'hash'             => $video->getHash() ?? '',
            'url_hash'         => $video->getUrlHash(),
            'thumbnail'        => $video->getThumbnail() ?? '',
            'duration_seconds' => $video->getDurationSeconds(),
            'type'             => $video->getType()->value,
            'mime'             => $video->getType()->getMime()
        ];

        return \Illuminate\Support\Facades\App::make(\App\Models\WatchHistory\Video::class, ['attributes' => $data]);
    }
}
