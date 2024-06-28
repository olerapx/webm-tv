<?php
declare(strict_types=1);

namespace App\View\Components;

class BoardLink extends \Illuminate\View\Component
{
    public function __construct(
        public readonly \App\Contracts\Website $website,
        public readonly string $code,
        public readonly string $title
    ) {

    }

    public function render()
    {
        return view('components.board-link');
    }

    public function url(): string
    {
        return url("/{$this->website->getCode()->value}/{$this->code}");
    }
}
