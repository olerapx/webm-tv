<x-app-layout>
    <x-page-title title="{{ $website->getTitle() }} - {{ $board }}"/>
    <x-player :website="$website" board="{{ $board }}"/>
</x-app-layout>
