<?php
declare(strict_types=1);

namespace App\Enums;

enum VideoType: string
{
    case MP4 = 'mp4';
    case WEBM = 'webm';

    public function getMime(): string
    {
        return match ($this) {
            self::WEBM => 'video/webm',
            self::MP4 => 'video/mp4',
        };
    }
}
