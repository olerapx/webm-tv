<?php
declare(strict_types=1);

namespace App\Models;

class Video extends DataObject implements \App\Contracts\Video
{
    public const string URL = 'url';
    public const string NAME = 'name';
    public const string THUMBNAIL = 'thumbnail';
    public const string HASH = 'hash';
    public const string TYPE = 'type';
    public const string SORT_ORDER = 'sort_order';
    public const string DURATION_SECONDS = 'duration_seconds';

    public function getUrl(): string
    {
        return $this->getAttribute(self::URL);
    }

    public function getName(): string
    {
        return $this->getAttribute(self::NAME);
    }

    public function getThumbnail(): ?string
    {
        return $this->getAttribute(self::THUMBNAIL);
    }

    public function getHash(): ?string
    {
        return $this->getAttribute(self::HASH);
    }

    public function getUrlHash(): string
    {
        return sha1($this->getUrl());
    }

    public function getType(): \App\Enums\VideoType
    {
        return $this->getAttribute(self::TYPE);
    }

    public function getDurationSeconds(): int
    {
        return $this->getAttribute(self::DURATION_SECONDS);
    }

    public function getSortOrder(): int
    {
        return $this->getAttribute(self::SORT_ORDER);
    }

    public function jsonSerialize(): mixed
    {
        $result = parent::jsonSerialize();

        if (is_array($result)) {
            $result['mime'] = $this->getType()->getMime();
            $result['url_hash'] = $this->getUrlHash();
        }

        return $result;
    }
}
