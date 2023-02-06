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
        $this->app->singleton(\App\Models\Meta::class);
    }

    public function boot()
    {
        $this->registerMeta();
    }

    private function registerMeta(): void
    {
        $file = base_path('routes/meta.php');
        $meta = $this->app->make(\App\Models\Meta::class);

        if (is_file($file)) {
            require $file;
        }
    }
}
