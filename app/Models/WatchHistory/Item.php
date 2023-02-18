<?php
declare(strict_types=1);

namespace App\Models\WatchHistory;

class Item extends \Illuminate\Database\Eloquent\Model
{
    use \Laravel\Scout\Searchable;

    public function searchableAs()
    {
        return 'watch_history';
    }
}
