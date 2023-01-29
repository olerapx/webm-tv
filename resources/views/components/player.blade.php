<div class="flex flex-col md:flex-row w-full h-screen mt-8"
     x-data="{component: new Player($el, '{{ $website->getCode()->value }}', '{{ $board }}')}"
     x-init="component.init(); $el.scrollIntoView({behavior: 'smooth'});">

    <div class="hidden animate-spin inline w-8 h-8 mr-2 text-gray-200"></div>

    <div x-show="!component.state.isInited()" class="absolute w-full h-full z-50 overflow-hidden bg-gray-700 flex flex-col items-center justify-center">
        <div x-show="component.state.isLoading()" role="status">{!! $svg('loading') !!}</div>

        <div x-show="component.state.isNoVideos()">
            <div class="text-gray-400 text-lg" role="alert">
                <div class="inline-flex">
                    <div class="pt-0.5">{!! $svg('info') !!}</div>
                    <div class="font-bold drop-shadow-md">
                        <span>{{ __('Looks like the board does not contain videos.') }}</span>
                        <a class="underline" href="{{ url("/{$website->getCode()->value}") }}">{{ __('Try another one.') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="w-full h-screen overflow-y-auto md:overflow-hidden bg-black flex items-center shrink-0 md:shrink">
        <video
            controls
            preload="auto"
            class="js-plyr-video"
            data-website="{{ $website->getCode()->value }}"
            data-board="{{ $board }}">
        </video>
    </div>

{{-- SHOW ELEMENT IN SCROLL BAR BUT DO NOT SCROLL THE SCREEN ; SHOW SOME CONTROL TO SCROLL TO PLAYLIST ON MOBILE; AFTER SELECTING THE ITEM (CLICK) SCROLL THE VIDEO BACK INTO VIEW    --}}

    <div class="plyr-playlist-wrapper">
        <ul class="js-plyr-playlist plyr-playlist flex flex-wrap justify-center md:block">
            <template x-for="(item, index) in component.playlist.items">
                <li class="playlist-item"
                    x-init="$watch('item.playing', val => { val })"
                    :class="{'pls-playing': item.playing}">
                    <a class="flex flex-col" x-on:click="await component.select(index);">
                        <img class="plyr-miniposter" x-bind:src="item.video.poster" />
                        <span x-text="item.video.title"></span>
                    </a>
                </li>
            </template>

            <li x-show="component.state.isLoading()" class="playlist-item-loader flex flex-col justify-center">
                <div class="flex flex-col items-center">{!! $svg('loading') !!}</div>
            </li>
        </ul>
    </div>

    <template class="js-plyr-buttons">
        <button type="button" data-reference="[data-plyr='play']" data-position="before" x-show="component.playlist.prev() !== null" class="plyr__controls__item plyr__control" x-on:click="await component.selectPrev()">{!! $svg('prev') !!}</button>
        <button type="button" data-reference="[data-plyr='play']" data-position="after" x-show="component.playlist.next() !== null" class="plyr__controls__item plyr__control" x-on:click="await component.selectNext()">{!! $svg('next') !!}</button>
        <button type="button" data-reference="[data-plyr='settings']" data-position="before" class="plyr__controls__item plyr__control" x-on:click="component.download()">{!! $svg('download') !!}</button>
        <button type="button" data-reference="[data-plyr='settings']" data-position="before" class="plyr__controls__item plyr__control js-plyr-share-button" x-on:click="component.share()">{!! $svg('share') !!}</button>
        <button type="button" data-reference="[data-plyr='settings']" data-position="before" x-init="HotkeyTooltip.add($el)" class="hidden md:block plyr__controls__item plyr__control">{!! $svg('hotkeys') !!}</button>
    </template>
</div>
