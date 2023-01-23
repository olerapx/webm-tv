<x-app-layout>
    <x-page-title title="{{ $website->getTitle() }} - {{ $board }}"/>

    <div id="#player" data-vjs-player="true">
        <video
            controls
            preload="auto"
            class="video-js vjs-big-play-centered vjs-fluid mt-8 mx-12"
            data-setup='{"autoplay": false}'
            data-website="{{ $website->getCode()->value }}"
            data-board="{{ $board }}"
            x-data="{}"
            x-init="$dispatch('board-player-init', {element: $el})">
        </video>

        <div class="playlist-container">
            <ol class="vjs-playlist"></ol>
        </div>
    </div>
</x-app-layout>
