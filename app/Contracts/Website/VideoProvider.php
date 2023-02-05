<?php
declare(strict_types=1);

namespace App\Contracts\Website;

interface VideoProvider
{
    public function getBoards(): array;

    /**
     * @return \App\Contracts\Video[]
     */
    public function getVideos(\App\Contracts\Video\FetchRequest $fetchRequest): array;
}
