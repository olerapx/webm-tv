<?php

/** @var \App\Models\Breadcrumbs $breadcrumbs */

$breadcrumbs->for('index', function (\App\Models\BreadcrumbGenerator $generator) {
    $generator->push('webm', route('index'));
});

$breadcrumbs->for('profile', function (\App\Models\BreadcrumbGenerator $generator) {
    $generator
        ->push('webm', route('index'))
        ->push('me', route('me'));
});

$breadcrumbs->for('howto', function (\App\Models\BreadcrumbGenerator $generator, \App\Enums\Website $website) {
    $generator
        ->push('webm', route('index'))
        ->push("howto-{$website->value}", url("/howto/{$website->value}"));
});

$breadcrumbs->for('website', function (\App\Models\BreadcrumbGenerator $generator, \App\Enums\Website $website) {
    $generator
        ->push('webm', route('index'))
        ->push($website->value, url("/{$website->value}"));
});

$breadcrumbs->for('board', function (\App\Models\BreadcrumbGenerator $generator, \App\Enums\Website $website, string $board) {
    $generator
        ->push('webm', route('index'))
        ->push($website->value, url("/{$website->value}"))
        ->push($board, url("/{$website->value}/{$board}"));
});
