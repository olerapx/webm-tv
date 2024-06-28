<?php
declare(strict_types=1);

namespace App\Services\WebsiteProvider\Dvach\VideoProvider;

readonly class Extractor
{
    private const int API_WEBM = 6;
    private const int API_MP4 = 10;

    public static function extract(array $response): \Generator
    {
        $posts = $response['threads'][0]['posts'] ?? [];

        foreach ($posts as $post) {
            foreach ($post['files'] ?? [] as $file) {
                $videoType = self::apiToVideoType((int) $file['type']);

                if (!$videoType) {
                    continue;
                }

                $thumbnail = isset($file['thumbnail']) ? Url::url($file['thumbnail']) : null;

                yield \Illuminate\Support\Facades\App::make(\App\Models\Video::class, [
                    'data' => [
                        \App\Models\Video::URL              => Url::url($file['path']),
                        \App\Models\Video::NAME             => $file['name'],
                        \App\Models\Video::HASH             => $file['md5'],
                        \App\Models\Video::TYPE             => $videoType,
                        \App\Models\Video::THUMBNAIL        => $thumbnail,
                        \App\Models\Video::DURATION_SECONDS => (int) ($file['duration_secs'] ?? null),
                        \App\Models\Video::SORT_ORDER       => (int) $file['name']
                    ]
                ]);
            }
        }
    }

    private static function apiToVideoType(int $type): ?\App\Enums\VideoType
    {
        return match ($type) {
            self::API_WEBM => \App\Enums\VideoType::WEBM,
            self::API_MP4 => \App\Enums\VideoType::MP4,
            default => null
        };
    }
}
