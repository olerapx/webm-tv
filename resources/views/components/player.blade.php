<div class="flex w-full h-screen mt-8"
     x-data="{component: new Player($el, '{{ $website->getCode()->value }}', '{{ $board }}')}"
     x-init="component.init(); $el.scrollIntoView({behavior: 'smooth'});">

    <div x-show="!component.inited" class="fixed top-0 left-0 right-0 bottom-0 w-full h-screen z-50 overflow-hidden bg-gray-700 flex flex-col items-center justify-center">
        <div role="status">{!! $svg('loading') !!}</div>
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
            <template x-for="(item, index) in component.playlist.items">
                <li class="playlist-item" :class="{'pls-playing': item.playing}">
                    <a class="flex flex-col" x-on:click="await component.select(index); $el.scrollIntoView({block: 'nearest', inline: 'nearest'});">
                        <img class="plyr-miniposter" x-bind:src="item.video.poster" />
                        <span x-text="item.video.title"></span>
                    </a>
                </li>
            </template>

            <li x-show="component.loading" class="playlist-item-loader flex flex-col justify-center">
                <div class="flex flex-col items-center">{!! $svg('loading') !!}</div>
            </li>
        </ul>
    </div>

    <template class="js-plyr-buttons">
        <button type="button" data-reference="[data-plyr='play']" data-position="before" x-show="component.playlist.prev() !== null" class="plyr__controls__item plyr__control" x-on:click="await component.selectPrev()">{!! $svg('prev') !!}</button>
        <button type="button" data-reference="[data-plyr='play']" data-position="after" x-show="component.playlist.next() !== null" class="plyr__controls__item plyr__control" x-on:click="await component.selectNext()">{!! $svg('next') !!}</button>
        <button type="button" data-reference="[data-plyr='settings']" data-position="after" class="plyr__controls__item plyr__control" x-on:click="component.download()">{!! $svg('download') !!}</button>
        <button type="button" data-reference="[data-plyr='settings']" data-position="after" class="plyr__controls__item plyr__control js-plyr-share-button" x-on:click="component.share()">{!! $svg('share') !!}</button>
    </template>
</div>
