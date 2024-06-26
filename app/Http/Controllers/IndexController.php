<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __construct(private readonly \App\Contracts\WebsiteProvider $websiteProvider)
    {

    }

    public function index(Request $request): \Illuminate\View\View
    {
        return view('index');
    }

    public function website(Request $request, \App\Enums\Website $website): \Illuminate\View\View
    {
        return view('website', [
            'website' => $this->websiteProvider->getAll()[$website->value]
        ]);
    }

    public function board(Request $request, \App\Enums\Website $website, string $board): \Illuminate\View\View
    {
        $website = $this->websiteProvider->getAll()[$website->value];
        if (!in_array($board, array_keys($website->getVideoProvider()->getBoards()))) {
            abort(404);
        }

        return view('board', [
            'website' => $website,
            'board'   => $board
        ]);
    }
}
