<?php
declare(strict_types=1);

namespace App\Http\Middleware;

class ResolveVideoProvider
{
    private \App\Contracts\WebsiteProvider $websiteProvider;

    public function __construct(
        \App\Contracts\WebsiteProvider $websiteProvider
    ) {
        $this->websiteProvider = $websiteProvider;
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

        $request->merge([
            'provider' => $provider
        ]);

        return $next($request);
    }
}
