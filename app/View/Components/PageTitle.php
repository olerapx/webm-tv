<?php
declare(strict_types=1);

namespace App\View\Components;

class PageTitle extends \Illuminate\View\Component
{
    public \App\Models\Breadcrumbs $breadcrumbs;

    public function __construct(
        \App\Models\Breadcrumbs $breadcrumbs
    ) {
        $this->breadcrumbs = $breadcrumbs;
    }

    public function render(): \Illuminate\View\View
    {
        return view('components.page-title');
    }
}
