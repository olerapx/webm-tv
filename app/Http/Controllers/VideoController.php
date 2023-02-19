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
        $provider = $this->websiteProvider->getAll()[$request->input('website')] ?? null;
        if (!$provider) {
            throw new \Symfony\Component\HttpKernel\Exception\HttpException(400, __('Unsupported website'));
        }

        if (!in_array($request->input('board'), array_keys($provider->getVideoProvider()->getBoards()))) {
            throw new \Symfony\Component\HttpKernel\Exception\HttpException(400, __('Unsupported board'));
        }

        $apiRequest = \Illuminate\Support\Facades\App::make(
            \App\Models\Video\FetchRequest::class,
            ['data' => $request->input()]
        );
        return response()->json($provider->getVideoProvider()->getVideos($apiRequest));
    }

    public function addToHistory()
    {
        // TODO:
        // validate authorized via middleware
        // accept multiple videos but no more than 10(?)

        $video =
            \App\Models\WatchHistory\Video::from(new \App\Models\Video(), \Illuminate\Support\Facades\Auth::user());
        $video->save();
    }
}
