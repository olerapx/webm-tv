<?php
declare(strict_types=1);

namespace App\Contracts\Video;

interface FetchRequest
{
    public function getWebsite(): string;

    public function getBoard(): string;

    public function getCount(): ?int;

    public function setCount(int $value): self;

    public function getPlaylistHashes(): array;

    public function getAccessCode(): ?string;
}
