<?php
declare(strict_types=1);

namespace App\Services;

class Http
{
    private ?\GuzzleHttp\ClientInterface $client = null;

    public function json(string $url, array $cookies = []): \GuzzleHttp\Promise\PromiseInterface
    {
        return $this->get($url, $cookies)->then(function (string $response) {
            return json_decode($response, true, 512, JSON_THROW_ON_ERROR);
        });
    }

    public function get(string $url, array $cookies = []): \GuzzleHttp\Promise\PromiseInterface
    {
        $jar = \GuzzleHttp\Cookie\CookieJar::fromArray(
            array_filter($cookies),
            \Spatie\Url\Url::fromString($url)->getHost()
        );

        return $this->client()
            ->requestAsync('GET', $url, ['cookies' => $jar])
            ->then(function (\Psr\Http\Message\ResponseInterface $response) {
            if ($response->getStatusCode() < 200 || $response->getStatusCode() >= 300) {
                throw new \Symfony\Component\HttpKernel\Exception\HttpException($response->getStatusCode());
            }

            return $response->getBody()->getContents();
        });
    }

    private function client(): \GuzzleHttp\ClientInterface
    {
        if ($this->client === null) {
            $this->client = new \GuzzleHttp\Client();
        }

        return $this->client;
    }
}
