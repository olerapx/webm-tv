<?php
declare(strict_types=1);

namespace App\Contracts;

interface Video extends \JsonSerializable
{
    public function getUrl(): string;

    public function getName(): string;

    public function getThumbnail(): ?string;

    public function getHash(): ?string;

    public function getUrlHash(): string;

    public function getType(): \App\Enums\VideoType;

    public function getDurationSeconds(): int;

    public function getSortOrder(): int;
}
