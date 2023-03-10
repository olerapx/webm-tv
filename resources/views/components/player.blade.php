@php /** @var \App\Contracts\Website $website */ @endphp

<div class="flex flex-col md:flex-row w-full h-[calc(100vh-var(--header-height)-1px)] overflow-hidden"
     x-data="{component: new Player($el, '{{ $website->getCode()->value }}', '{{ $board }}')}"
     x-cloak
     x-init="component.init()">

    <div class="hidden animate-spin inline w-8 h-8 mr-2 text-gray-200"></div>

    <div x-cloak
         x-show="component.state.isInited() === false"
         class="absolute w-full h-full z-50 overflow-hidden bg-gray-700 flex flex-col items-center justify-center">
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

        <div x-show="component.state.isClosedBoard()">
            <div class="text-gray-400 text-lg mx-5 flex flex-col items-center" role="alert">
                <div class="inline-flex">
                    <div class="pt-0.5">{!! $svg('info') !!}</div>
                    <div class="font-bold drop-shadow-md"><span>{{ __('This board is closed.') }}</span></div>
                </div>

                <div class="my-4 max-w-lg text-center">{{ __('To get access to the board, follow the') }}
                    <a class="underline" target="_blank" href="{{ url("/howto/{$website->getCode()->value}") }}">{{ __('instructions') }}</a>,
                    {{ __('and enter the obtained access code into the field below.') }}
                </div>

                <form method="POST" x-data="{access: new AccessCode($el)}" x-on:submit.prevent="access.submit()">
                    @csrf
                    <input type="hidden" name="website" value="{{ $website->getCode()->value }}">
                    <div class="inline-flex mt-5">
                        <x-text-input id="code" class="block mx-3 text-black" type="text" name="code" placeholder="{{ __('Access Code') }}" required autocomplete="off" />
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold rounded-lg px-2">{{ __('Enter') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="w-full overflow-hidden bg-black flex items-center shrink-0 md:shrink h-[50vh] md:h-[calc(100vh-var(--header-height)-1px)]">
        <video
            controls
            preload="auto"
            class="js-plyr-video"
            data-website="{{ $website->getCode()->value }}"
            data-board="{{ $board }}">
        </video>
    </div>

    <div class="plyr-playlist-wrapper overflow-y-auto grow">
        <ul class="js-plyr-playlist plyr-playlist flex flex-wrap justify-center md:block mr-2 mt-1 md:mt-0">
            <template x-for="(item, index) in component.playlist.items">
                <li class="playlist-item"
                    x-init="$watch('item.playing', val => { val && $el.scrollIntoView({block: 'nearest', inline: 'nearest'}); })"
                    :class="{'pls-playing': item.playing}">
                    <a class="flex flex-col relative text-gray-200 text-md font-semibold py-2 px-2" x-on:click="await component.select(index);">
                        <img class="plyr-miniposter h-36 w-64" x-bind:src="item.video.poster" />
                        <span class="plyr-title" x-text="item.video.title"></span>
                        <span class="plyr-duration text-sm font-semibold absolute right-0 mr-3 mt-1" x-show="item.video.duration" x-text="item.duration()"></span>
                    </a>
                </li>
            </template>

            <li x-show="component.state.isLoading()" class="playlist-item-loader flex flex-col justify-center items-center">
                <div class="flex flex-col justify-center items-center h-36 w-64">{!! $svg('loading') !!}</div>
            </li>
        </ul>
    </div>

    <template class="js-plyr-buttons">
        <button type="button" data-reference="[data-plyr='play']" data-position="before" x-show="component.playlist.prev() !== null" class="plyr__controls__item plyr__control" x-on:click="await component.selectPrev()">{!! $svg('prev') !!}</button>
        <button type="button" data-reference="[data-plyr='play']" data-position="after" x-show="component.playlist.next() !== null" class="plyr__controls__item plyr__control" x-on:click="await component.selectNext()">{!! $svg('next') !!}</button>
        <button type="button" data-reference=".plyr__volume" data-position="after" class="flex-grow"></button>
        <button type="button" data-reference="[data-plyr='settings']" data-position="before" class="plyr__controls__item plyr__control" x-on:click="component.download()">{!! $svg('download') !!}</button>
        <button type="button" data-reference="[data-plyr='settings']" data-position="before" class="plyr__controls__item plyr__control js-plyr-share-button" x-on:click="component.share()">{!! $svg('share') !!}</button>
        <button type="button" data-reference="[data-plyr='settings']" data-position="before" x-init="HotkeyTooltip.add($el)" class="hidden lg:block plyr__controls__item plyr__control">{!! $svg('hotkeys') !!}</button>
    </template>
</div>
