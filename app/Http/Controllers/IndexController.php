<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    private \App\Contracts\WebsiteProvider $websiteProvider;

    public function __construct(\App\Contracts\WebsiteProvider $websiteProvider)
    {
        $this->websiteProvider = $websiteProvider;
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
        var_dump($website);
        var_dump($board);
        die;
    }
}
