<?php
declare(strict_types=1);

namespace App\View\Components;

class BoardLink extends \Illuminate\View\Component
{
    public \App\Contracts\Website $website;
    public string $code;
    public string $title;

    public function __construct(\App\Contracts\Website $website, string $code, string $title)
    {
        $this->website = $website;
        $this->code = $code;
        $this->title = $title;
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
