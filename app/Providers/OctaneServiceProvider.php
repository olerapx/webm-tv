<?php
declare(strict_types=1);

namespace App\Providers;

class OctaneServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../../config/octane.php', 'octane');
    }
}
