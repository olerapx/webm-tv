<?php
declare(strict_types=1);

namespace App\Services\WebsiteProvider\Dvach;

class Http
{
    const BASE_URL = 'https://2ch.hk';

    public function json(string $uri): array
    {
        // TODO: EXTRACT TO COMMON
        $response = \Illuminate\Support\Facades\Http::get(self::BASE_URL . '/' . $uri);

        if (!$response->successful()) {
            throw new \Symfony\Component\HttpKernel\Exception\HttpException($response->status());
        }

        return $response->json();
    }
}
