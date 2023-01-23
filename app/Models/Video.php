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

    public function jsonSerialize(): mixed
    {
        $result = parent::jsonSerialize();

        if (is_array($result)) {
            $result['mime'] = $this->getType()->getMime();
        }

        return $result;
    }
}
