<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

require __DIR__.'/auth.php';

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
});

Route::controller(\App\Http\Controllers\IndexController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/{website}', 'website');
    Route::get('/{website}/{board}', 'board');
});
