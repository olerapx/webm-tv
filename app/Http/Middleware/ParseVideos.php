<?php
declare(strict_types=1);

namespace App\Http\Middleware;

use Illuminate\Support\Facades\App;

readonly class ParseVideos
{
    public function handle(\Illuminate\Http\Request $request, \Closure $next)
    {
        $videos = array_map(
            fn(array $video) => App::make(\App\Models\Video::class, ['data' => $video]),
            $request->input('videos')
        );

        $request->merge([
            'video_objects' => $videos
        ]);

        return $next($request);
    }
}
