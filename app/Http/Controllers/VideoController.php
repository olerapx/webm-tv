<?php
declare(strict_types=1);

namespace App\Http\Controllers;

class VideoController
{
    public function fetch(\App\Http\Requests\Video\FetchRequest $request): \Illuminate\Http\JsonResponse
    {
        $website = $request->get('website');
        $board = $request->get('board');
        $count = $request->get('count');

        return response()->json([

        ]);
    }
}
