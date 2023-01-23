<?php
declare(strict_types=1);

namespace App\Http\Controllers;

class ProfileController extends Controller
{
    public function index(\Illuminate\Http\Request $request): \Illuminate\View\View
    {
        return view('profile', [
            'user' => $request->user(),
        ]);
    }
}
