<div class="flex w-full h-screen mt-8"
     x-data="{component: new Player($el, '{{ $website->getCode()->value }}', '{{ $board }}')}"
     x-init="component.load(); $el.scrollIntoView({behavior: 'smooth'});">
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
