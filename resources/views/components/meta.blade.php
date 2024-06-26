@php
    /** @var \App\Models\Meta $meta */
    $metadata = $meta->metadata();
 @endphp

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="description" content="{!! $metadata['desc'] !!}">
<title>{!! $metadata['title'] !!}</title>
