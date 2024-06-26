<?php
declare(strict_types=1);

namespace App\View\Components;

class WebsiteCard extends \Illuminate\View\Component
{
    public function __construct(public readonly \App\Contracts\Website $website)
    {

    }

    public function render(): \Illuminate\View\View
    {
        return view('components.website-card');
    }

    public function svg(): string
    {
        return \Illuminate\Support\Facades\File::get(
            resource_path("static/websites/{$this->website->getCode()->value}.svg")
        );
    }

    public function url(): string
    {
        return url("/{$this->website->getCode()->value}");
    }
}
