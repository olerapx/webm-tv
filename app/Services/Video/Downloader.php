<?php
declare(strict_types=1);

namespace App\Services\Video;

readonly class Downloader implements \App\Contracts\Downloader
{
    private const MAX_SIZE = 50 * 1024 * 1024;

    public function __construct(private \App\Contracts\WebsiteProvider $websiteProvider)
    {

    }

    public function download(string $file)
    {
        $url = \Spatie\Url\Url::fromString($file);

        if (!in_array($url->getHost(), $this->websiteProvider->getAllowedDomains())) {
            throw new \Exception('Invalid host');
        }

        $client = new \GuzzleHttp\Client();
        $headers = $client->head($file)->getHeaders();

        $length = $headers['Content-Length'][0] ?? 0;
        if (!$length || $length > self::MAX_SIZE) {
            throw new \Exception('File is too large, resolve to redirecting');
        }

        ob_end_clean();

        header('Content-Disposition: attachment; filename=' . basename($file));
        header('Content-Type: application/octet-stream');
        header('Content-Length: '. $length);
        readfile($file);
    }
}
