<?php
declare(strict_types=1);

namespace App\View\Components;

class WebsiteGrid extends \Illuminate\View\Component
{
    public \App\Services\WebsiteProvider $websiteProvider;

    public function __construct(\App\Services\WebsiteProvider $websiteProvider)
    {
        $this->websiteProvider = $websiteProvider;
    }

    public function render()
    {
        return view('components.website-grid');
    }
}
