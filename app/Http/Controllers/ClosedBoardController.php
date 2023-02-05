<?php
declare(strict_types=1);

namespace App\Http\Controllers;

class ClosedBoardController extends Controller
{
    private \App\Contracts\WebsiteProvider $websiteProvider;

    public function __construct(\App\Contracts\WebsiteProvider $websiteProvider)
    {
        $this->websiteProvider = $websiteProvider;
    }

    public function howTo(\Illuminate\Http\Request $request, \App\Enums\Website $website): \Illuminate\View\View
    {
        return view("howto/{$website->value}");
    }
}
