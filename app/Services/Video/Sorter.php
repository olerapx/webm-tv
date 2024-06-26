<?php
declare(strict_types=1);

namespace App\Services\Video;

readonly class Sorter
{
    public static function sort(array $videos): array
    {
        usort($videos, function (\App\Contracts\Video $a, \App\Contracts\Video $b) {
            return $b->getSortOrder() <=> $a->getSortOrder();
        });

        return $videos;
    }
}
