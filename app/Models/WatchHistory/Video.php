<?php
declare(strict_types=1);

namespace App\Models\WatchHistory;

class Video extends \Illuminate\Database\Eloquent\Model
{
    use \Laravel\Scout\Searchable;

    protected $keyType = 'string';

    public static function from(\App\Models\Video $video, \Illuminate\Contracts\Auth\Authenticatable $user): self
    {
        $data = $video->jsonSerialize();

        $video = new \App\Models\WatchHistory\Video();

        $video->fill([
            'id'   => \Symfony\Component\Uid\Ulid::generate(),
            'url'  => 'aa',
            'user' => $user->name
        ]);

        // TODO: convert all fields

        return $video;
    }

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
