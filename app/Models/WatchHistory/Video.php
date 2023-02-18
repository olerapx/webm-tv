<?php
declare(strict_types=1);

namespace App\Models\WatchHistory;

class Video extends \Illuminate\Database\Eloquent\Model
{
    use \Laravel\Scout\Searchable;

    protected $keyType = 'string';

    protected $guarded = [];

    public function searchableAs(): string
    {
        return 'watch_history';
    }

    public function save(array $options = []): self
    {
        $this->finishSave($options);
        return $this;
    }
}
