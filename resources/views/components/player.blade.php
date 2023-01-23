<div class="flex w-full h-screen mt-8"
     x-data="{component: new Player($el, '{{ $website->getCode()->value }}', '{{ $board }}')}"
     x-init="component.load(); $el.scrollIntoView({behavior: 'smooth'});">

    <div x-show="!component.loaded" class="fixed top-0 left-0 right-0 bottom-0 w-full h-screen z-50 overflow-hidden bg-gray-700 flex flex-col items-center justify-center">
        <div class="loader ease-linear rounded-full border-4 border-t-4 border-gray-200 h-12 w-12 mb-4"></div>
        <h2 class="text-center text-white text-xl font-semibold">Loading...</h2>
    </div>

    <video
        controls
        preload="auto"
        class="js-plyr-video"
        data-website="{{ $website->getCode()->value }}"
        data-board="{{ $board }}">
    </video>

    <div class="plyr-playlist-wrapper">
        <ul class="js-plyr-playlist plyr-playlist">
            <template x-for="item in component.playlist.items">
                <li class="playlist-item" :class="{'pls-playing': item.playing}">
                    <a class="flex flex-col" x-on:click="component.playlist.select(item)">
                        <img class="plyr-miniposter" x-bind:src="item.video.poster" />
                        <span x-text="item.video.title"></span>
                    </a>
                </li>
            </template>
        </ul>
    </div>

    <template class="js-plyr-prev">
        <button type="button" class="plyr__controls__item plyr__control" x-on:click="component.playlist.prev()">{!! $svg('prev') !!}</button>
    </template>

    <template class="js-plyr-next">
        <button type="button" class="plyr__controls__item plyr__control" x-on:click="component.playlist.next()">{!! $svg('next') !!}</button>
    </template>

    <template class="js-plyr-download">
        <button type="button" class="plyr__controls__item plyr__control" x-on:click="component.download()">{!! $svg('download') !!}</button>
    </template>

    <template class="js-plyr-share">
        <button type="button" class="plyr__controls__item plyr__control js-plyr-share-button" x-on:click="component.share()">{!! $svg('share') !!}</button>
    </template>
</div>
