<?php
declare(strict_types=1);

namespace App\Services\WebsiteProvider;

class Dvach implements \App\Contracts\Website
{

    public function getCode(): \App\Enums\Website
    {
        return \App\Enums\Website::Dvach;
    }

    public function getTitle(): string
    {
        return '2ch.hk';
    }

    public function getAllowedDomains(): array
    {
        return [
            '2ch.hk'
        ];
    }

    public function getVideoProvider(): \App\Contracts\Website\VideoProvider
    {
        return \Illuminate\Support\Facades\App::make(\App\Services\WebsiteProvider\Dvach\VideoProvider::class);
    }
}
