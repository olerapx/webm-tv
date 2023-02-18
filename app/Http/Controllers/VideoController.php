<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class VideoController extends Controller
{
    public function __construct(
        private readonly \App\Services\WatchHistory $watchHistory,
        private readonly \App\Contracts\WebsiteProvider $websiteProvider
    ) {

    }

    public function fetch(\App\Http\Requests\Video\FetchRequest $request): \Illuminate\Http\JsonResponse
    {
        Log::channel('video_fetch')->info('Fetch', ['request' => $request->input()]);

        $provider = $this->websiteProvider->getAll()[$request->input('website')] ?? null;
        $apiRequest = App::make(\App\Models\Video\FetchRequest::class, ['data' => $request->input()]);

        return response()->json($provider->getVideoProvider()->getVideos($apiRequest));
    }

    public function addToHistory(\App\Http\Requests\Video\AddToHistoryRequest $request): \Illuminate\Http\JsonResponse
    {
        Log::channel('video_history')->info('Add to History', ['request' => $request->input()]);

        $user = \Illuminate\Support\Facades\Auth::user();
        $this->watchHistory->add(
            $request->input('video_objects'),
            $request->input('website'),
            $request->input('board'),
            $user
        );

        return response()->json();
    }
}
