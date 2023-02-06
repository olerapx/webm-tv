@php /** @var \App\Models\Meta $meta */ @endphp

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="description" content="{!! $meta->metaDescription() !!}">
<title>{{ config('app.name', 'Laravel') }}</title>
