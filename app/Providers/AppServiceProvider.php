<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(\App\Contracts\WebsiteProvider::class, \App\Services\WebsiteProvider::class);
    }

    public function boot()
    {

    }
}
