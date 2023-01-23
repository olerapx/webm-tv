<?php
declare(strict_types=1);

namespace App\Models;

abstract class DataObject implements \JsonSerializable
{
    private array $data;

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    public function getAttribute(string $key)
    {
        return $this->data[$key] ?? null;
    }

    public function jsonSerialize(): mixed
    {
        return $this->data;
    }
}
