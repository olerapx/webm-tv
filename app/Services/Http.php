<?php
declare(strict_types=1);

namespace App\Services;

class Http
{
    public function json(string $url): array
    {
        $response = \Illuminate\Support\Facades\Http::get($url);

        if (!$response->successful()) {
            throw new \Symfony\Component\HttpKernel\Exception\HttpException($response->status());
        }

        return $response->json();
    }
}
