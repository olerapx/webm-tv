<?php
declare(strict_types=1);

namespace App\Http\Controllers;

class VideoController
{
    private \App\Contracts\WebsiteProvider $websiteProvider;

    public function __construct(
        \App\Contracts\WebsiteProvider $websiteProvider
    ) {
        $this->websiteProvider = $websiteProvider;
    }

    public function fetch(\App\Http\Requests\Video\FetchRequest $request): \Illuminate\Http\JsonResponse
    {
        $website = $request->get('website');
        $board = $request->get('board');
        $count = $request->get('count');

        $provider = $this->websiteProvider->getAll()[$website] ?? null;
        if (!$provider) {
            throw new \Symfony\Component\HttpKernel\Exception\HttpException(400, 'Unsupported provider');
        }

        if (!in_array($board, array_keys($provider->getVideoProvider()->getBoards()))) {
            throw new \Symfony\Component\HttpKernel\Exception\HttpException(400, 'Unsupported board');
        }

        return response()->json($provider->getVideoProvider()->getVideos($board, $count));
    }
}
