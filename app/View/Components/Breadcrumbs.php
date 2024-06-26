<?php
declare(strict_types=1);

namespace App\View\Components;

class Breadcrumbs extends \Illuminate\View\Component
{
    public function __construct(
        public readonly \App\Models\Meta $meta
    ) {

    }

    public function render(): \Illuminate\View\View
    {
        return view('components.breadcrumbs');
    }
}
