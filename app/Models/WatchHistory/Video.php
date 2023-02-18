<?php
declare(strict_types=1);

namespace App\Models\WatchHistory;

class Video extends \Illuminate\Database\Eloquent\Model
{
    public const string CREATED_TIMESTAMP = 'created_timestamp';

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

    public function prune(): void
    {
        /** @var \Meilisearch\Client $client */
        $client = app()->make(\Meilisearch\Client::class);

        $field = static::CREATED_TIMESTAMP;
        $date = now()->subMonth()->getTimestamp();

        $client->index($this->searchableAs())->deleteDocuments(['filter' => "$field <= $date"]);
    }
}
