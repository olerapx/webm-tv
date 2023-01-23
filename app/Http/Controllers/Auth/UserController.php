<?php
declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login(LoginRequest $request): RedirectResponse
    {
        try {
            $user = \App\Models\User::create([
                'name'     => $request->name,
                'password' => \Illuminate\Support\Facades\Hash::make($request->password)
            ]);

            event(new \Illuminate\Auth\Events\Registered($user));
        } catch (\Throwable $e) {
        }

        $request->authenticate();
        $request->session()->regenerate();

        return redirect()->intended('/');
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
