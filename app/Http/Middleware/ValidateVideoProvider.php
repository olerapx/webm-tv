<?php
declare(strict_types=1);

namespace App\Http\Middleware;

readonly class ValidateVideoProvider
{
    public function __construct(
        private \App\Contracts\WebsiteProvider $websiteProvider
    ) {

    }

    public function handle(\Illuminate\Http\Request $request, \Closure $next)
    {
        $provider = $this->websiteProvider->getAll()[$request->input('website')] ?? null;
        if (!$provider) {
            throw new \Symfony\Component\HttpKernel\Exception\HttpException(400, __('Unsupported website'));
        }

        if (!in_array($request->input('board'), array_keys($provider->getVideoProvider()->getBoards()))) {
            throw new \Symfony\Component\HttpKernel\Exception\HttpException(400, __('Unsupported board'));
        }

        return $next($request);
    }
}
