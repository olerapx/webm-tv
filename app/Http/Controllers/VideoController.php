<?php
declare(strict_types=1);

namespace App\Http\Controllers;

class VideoController extends Controller
{
    public function __construct(
        private readonly \App\Contracts\WebsiteProvider $websiteProvider
    ) {

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
}
