<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DownloadController extends Controller
{
    private \App\Contracts\Downloader $downloader;

    public function __construct(\App\Contracts\Downloader $downloader)
    {
        $this->downloader = $downloader;
    }

    public function download(Request $request): \Symfony\Component\HttpFoundation\Response
    {
        $file = $request->get('file');
        if (!$file) {
            abort(404);
        }

        try {
            return $this->downloader->download($file);
        } catch (\Throwable $e) {
            return redirect($file);
        }
    }
}
