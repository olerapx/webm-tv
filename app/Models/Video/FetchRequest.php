<?php
declare(strict_types=1);

namespace App\Models\Video;

class FetchRequest extends \App\Models\DataObject implements \App\Contracts\Video\FetchRequest
{
    const WEBSITE = 'website';
    const BOARD = 'board';
    const COUNT = 'count';
    const HASHES = 'hashes';
    const ACCESS_CODE = 'access_code';

    public function getWebsite(): string
    {
        return $this->getAttribute(self::WEBSITE);
    }

    public function getBoard(): string
    {
        return $this->getAttribute(self::BOARD);
    }

    public function getCount(): ?int
    {
        return $this->getAttribute(self::COUNT);
    }

    public function setCount(int $value): self
    {
        return $this->setAttribute(self::COUNT, $value);
    }

    public function getPlaylistHashes(): array
    {
        return $this->getAttribute(self::HASHES) ?? [];
    }

    public function getAccessCode(): ?string
    {
        return $this->getAttribute(self::ACCESS_CODE);
    }
}
