<?php
declare(strict_types=1);

namespace App\Http\Controllers;

class ClosedBoardController extends Controller
{
    public function howTo(\Illuminate\Http\Request $request, \App\Enums\Website $website): \Illuminate\View\View
    {
        return view("howto/{$website->value}");
    }
}
