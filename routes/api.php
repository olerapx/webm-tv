<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(\App\Http\Controllers\VideoController::class)
    ->middleware(\App\Http\Middleware\ResolveVideoProvider::class)->group(function () {
        Route::post('/video/fetch', 'fetch');

        Route::middleware('auth:sanctum')
            ->middleware(\App\Http\Middleware\ParseVideos::class)
            ->post('/video/add-to-history', 'addToHistory');
    });

Route::controller(\App\Http\Controllers\Auth\UserController::class)->group(function () {
    Route::post('/login', 'login')
        ->name('login');
});
