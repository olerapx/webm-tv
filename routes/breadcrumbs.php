<?php

/** @var \App\Models\Breadcrumbs $breadcrumbs */

$breadcrumbs->for('index', function (\App\Models\BreadcrumbGenerator $generator) {
    $generator->push('webm', route('index'));
});

$breadcrumbs->for('website', function (\App\Models\BreadcrumbGenerator $generator, \App\Enums\Website $website) {
    $generator->push('webm', route('index'));
    $generator->push($website->value, url("/{$website->value}"));
});

$breadcrumbs->for('board', function (\App\Models\BreadcrumbGenerator $generator, \App\Enums\Website $website, string $board) {
    $generator->push('webm', route('index'));
    $generator->push($website->value, url("/{$website->value}"));
    $generator->push($board, url("/{$website->value}/{$board}"));
});
