<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(\App\Http\Controllers\VideoController::class)->group(function () {
    Route::post('/video/fetch', 'fetch');
});

Route::controller(\App\Http\Controllers\Auth\UserController::class)->group(function () {
    Route::post('/login', 'login')
        ->middleware(\Illuminate\Session\Middleware\StartSession::class)
        ->name('login');
});
