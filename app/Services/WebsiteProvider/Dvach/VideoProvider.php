<?php
declare(strict_types=1);

namespace App\Services\WebsiteProvider\Dvach;

class VideoProvider implements \App\Contracts\Website\VideoProvider
{
    private Http $http;

    public function __construct(
         Http $http
    ) {
        $this->http = $http;
    }

    public function getBoards(): array
    {
        try {
            $json = $this->http->json('api/mobile/v2/boards');

            $result = [];
            foreach ($json as $row) {
                $result[] = new \App\Models\Website\Board($row['id'], $row['name']);
            }
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error($e->getMessage());
            return [];
        }

        return $result;// TODO CACHE
    }
}
