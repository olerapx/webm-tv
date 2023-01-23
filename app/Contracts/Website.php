<?php
declare(strict_types=1);

namespace App\Contracts;

interface Website
{
    public function getCode(): \App\Enums\Website;

    public function getTitle(): string;

    public function getVideoProvider(): \App\Contracts\Website\VideoProvider;
}
