<?php
declare(strict_types=1);

namespace App\Services\WebsiteProvider;

class Reddit implements \App\Contracts\Website
{

    public function getCode(): \App\Enums\Website
    {
        return \App\Enums\Website::Reddit;
    }

    public function getTitle(): string
    {
        return 'reddit.com';
    }

    public function getAllowedDomains(): array
    {
        return [];
    }

    public function getVideoProvider(): \App\Contracts\Website\VideoProvider
    {
        // TODO:
        return \Illuminate\Support\Facades\App::make(\App\Services\WebsiteProvider\Dvach\VideoProvider::class);
    }
}
