<?php
declare(strict_types=1);

namespace App\Contracts\Website;

interface VideoProvider
{
    public function getBoards(): array;

    public function getVideos(?int $count): array;
}
