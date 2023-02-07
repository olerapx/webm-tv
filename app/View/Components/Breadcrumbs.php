<?php
declare(strict_types=1);

namespace App\View\Components;

class Breadcrumbs extends \Illuminate\View\Component
{
    public \App\Models\Meta $meta;

    public function __construct(
        \App\Models\Meta $meta
    ) {
        $this->meta = $meta;
    }

    public function render(): \Illuminate\View\View
    {
        return view('components.breadcrumbs');
    }
}
