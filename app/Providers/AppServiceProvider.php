<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(\App\Contracts\WebsiteProvider::class, \App\Services\WebsiteProvider::class);
        $this->app->bind(\App\Contracts\Downloader::class, \App\Services\Video\Downloader::class);
        $this->app->singleton(\App\Services\Http::class);
        $this->app->singleton(\App\Models\Breadcrumbs::class);
    }

    public function boot()
    {
        $this->registerBreadcrumbs();
    }

    private function registerBreadcrumbs(): void
    {
        $file = base_path('routes/breadcrumbs.php');
        $breadcrumbs = $this->app->make(\App\Models\Breadcrumbs::class);

        if (is_file($file)) {
            require $file;
        }
    }
}
