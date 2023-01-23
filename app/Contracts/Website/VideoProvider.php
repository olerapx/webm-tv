<?php
declare(strict_types=1);

namespace App\Contracts\Website;

interface VideoProvider
{
    /**
     * @return Board[]
     */
    public function getBoards(): array;
}
