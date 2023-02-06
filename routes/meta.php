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
            'title' => 'Profile',
            'desc'  => 'Profile'
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
        $content = "How-to &mdash; {$website->value} &mdash; {$defaultTitle}";
        return [
            'title' => $content,
            'desc'  => $content
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
        $content = "{$website->value} &mdash; {$defaultTitle}";
        return [
            'title' => $content,
            'desc'  => $content
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
        $content = "{$board} &mdash; {$website->value} &mdash; {$defaultTitle}";
        return [
            'title' => $content,
            'desc'  => $content
        ];
    }
);
