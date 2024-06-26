<?php
declare(strict_types=1);

namespace App\Models;

abstract class DataObject implements \JsonSerializable
{
    public function __construct(private array $data = [])
    {

    }

    public function getAttribute(string $key): mixed
    {
        return $this->data[$key] ?? null;
    }

    public function setAttribute(string $key, $value): self
    {
        $this->data[$key] = $value;
        return $this;
    }

    public function jsonSerialize(): mixed
    {
        return $this->data;
    }
}
