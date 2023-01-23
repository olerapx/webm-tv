<?php
declare(strict_types=1);

namespace App\View\Components;

class WebsiteCard extends \Illuminate\View\Component
{
    private string $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function render(): \Illuminate\View\View
    {
        return view('components.website-card');
    }

    public function svg(): string
    {
        return \Illuminate\Support\Facades\File::get(resource_path("static/websites/{$this->path}.svg"));
    }
}
