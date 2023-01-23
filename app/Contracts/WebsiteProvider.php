<?php
declare(strict_types=1);

namespace App\Contracts;

interface WebsiteProvider
{
    /**
     * @return Website[]
     */
    public function getAll(): array;
}
