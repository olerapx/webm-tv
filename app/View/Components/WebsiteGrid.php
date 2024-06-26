<?php
declare(strict_types=1);

namespace App\View\Components;

class WebsiteGrid extends \Illuminate\View\Component
{
    public function __construct(public readonly \App\Services\WebsiteProvider $websiteProvider)
    {

    }

    public function render()
    {
        return view('components.website-grid');
    }
}
