<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PruneWatchHistory extends Command
{
    protected $signature = 'app:watch-history:prune';

    public function handle(): void
    {
        app()->make(\App\Models\WatchHistory\Video::class)->prune();
    }
}
