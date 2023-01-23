<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index(Request $request): \Illuminate\View\View
    {
        return view('index');
    }

    public function website(Request $request, \App\Enums\Website $website): \Illuminate\View\View
    {
        var_dump($website);
        die;
    }

    public function board(Request $request, \App\Enums\Website $website, string $board): \Illuminate\View\View
    {
        var_dump($website);
        var_dump($board);
        die;
    }
}
