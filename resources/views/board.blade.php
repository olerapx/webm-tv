@php /** @var \App\Enums\Website $website */ @endphp

<x-app-layout>
    <x-page-title />
    <x-player :website="$website" board="{{ $board }}"/>
</x-app-layout>
