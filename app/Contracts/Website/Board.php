<?php
declare(strict_types=1);

namespace App\Contracts\Website;

interface Board
{
    public function getCode(): string;

    public function getTitle(): string;
}
