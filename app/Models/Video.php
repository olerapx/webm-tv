<?php
declare(strict_types=1);

namespace App\Models;

class Video extends DataObject implements \App\Contracts\Video
{
    const URL = 'url';
    const NAME = 'name';
    const THUMBNAIL = 'thumbnail';
    const HASH = 'hash';
    const TYPE = 'type';
    const SORT_ORDER = 'sort_order';
    const DURATION_SECONDS = 'duration_seconds';

    public function __construct(array $data = [])
    {
        parent::__construct($data);

        if (!$this->getAttribute(self::TYPE) instanceof \App\Enums\VideoType) {
            $this->setAttribute(self::TYPE, \App\Enums\VideoType::from($this->getAttribute(self::TYPE)));
        }
    }

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
