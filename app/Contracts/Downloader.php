<?php
declare(strict_types=1);

namespace App\Contracts;

interface Downloader
{
    public function download(string $file);
}
