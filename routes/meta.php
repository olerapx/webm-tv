<?php
/** @var \App\Models\Meta $meta */

use App\Models\Meta\BreadcrumbGenerator;

$defaultTitle = config('app.name');

$meta->for('index', function (BreadcrumbGenerator $generator) {
    $generator->push('webm', route('index'));
});

$meta->for('profile',
    function (BreadcrumbGenerator $generator) {
        $generator
            ->push('webm', route('index'))
            ->push('me', route('me'));
    },
    function () {
        return [
            'desc' => 'Profile'
        ];
    }
);

$meta->for('howto',
    function (BreadcrumbGenerator $generator, \App\Enums\Website $website) {
        $generator
            ->push('webm', route('index'))
            ->push("howto-{$website->value}", url("/howto/{$website->value}"));
    },
    function (\App\Enums\Website $website) use ($defaultTitle) {
        return [
            'desc' => "How-to &mdash; {$website->value} &mdash; {$defaultTitle}"
        ];
    }
);

$meta->for('website',
    function (BreadcrumbGenerator $generator, \App\Enums\Website $website) {
        $generator
            ->push('webm', route('index'))
            ->push($website->value, url("/{$website->value}"));
    },
    function (\App\Enums\Website $website) use ($defaultTitle) {
        return [
            'desc' => "{$website->value} &mdash; {$defaultTitle}"
        ];
    }
);

$meta->for(
    'board',
    function (BreadcrumbGenerator $generator, \App\Enums\Website $website, string $board) {
        $generator
            ->push('webm', route('index'))
            ->push($website->value, url("/{$website->value}"))
            ->push($board, url("/{$website->value}/{$board}"));
    },
    function (\App\Enums\Website $website, string $board) use ($defaultTitle) {
        return [
            'desc' => "{$board} &mdash; {$website->value} &mdash; {$defaultTitle}"
        ];
    }
);
