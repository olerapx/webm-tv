<?php
declare(strict_types=1);

namespace App\View\Components;

class Player extends \Illuminate\View\Component
{
    public function __construct(
        public readonly \App\Contracts\Website $website,
        public readonly string $board
    ) {

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
