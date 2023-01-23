<?php
declare(strict_types=1);

namespace App\Services\WebsiteProvider\Dvach\VideoProvider;

class Url
{
    const BASE_URL = 'https://2ch.hk';

    public static function url(string $endpoint): string
    {
        return self::BASE_URL . '/' . $endpoint;
    }
}
