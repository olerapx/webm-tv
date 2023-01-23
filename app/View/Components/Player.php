<?php
declare(strict_types=1);

namespace App\View\Components;

class Player extends \Illuminate\View\Component
{
    public \App\Contracts\Website $website;
    public string $board;

    public function __construct(
        \App\Contracts\Website $website,
        string $board
    ) {
        $this->website = $website;
        $this->board = $board;
    }

    public function render(): \Illuminate\View\View
    {
        return view('components.player');
    }

    public function svg($name): string
    {
        return \Illuminate\Support\Facades\File::get(
            resource_path("static/player/{$name}.svg")
        );
    }
}
