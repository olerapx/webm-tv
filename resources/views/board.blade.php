<x-app-layout>
    <x-page-title title="{{ $website->getTitle() }} - {{ $board }}"/>

    <div class="flex w-full h-screen mt-8"
         x-data="{component: new Player($el, '{{ $website->getCode()->value }}', '{{ $board }}')}"
         x-init="component.load()">
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
                            <span class="plyr-minititle" x-text="item.video.title"></span>
                        </a>
                    </li>
                </template>

                <template class="js-plyr-prev">
                    <button type="button"
                            class="plyr__controls__item plyr__control"
                            x-on:click="component.playlist.prev()"
                    >
                            <svg id="Layer_1"
                                 xmlns="http://www.w3.org/2000/svg"
                                 xmlns:xlink="http://www.w3.org/1999/xlink"
                                 x="0px"
                                 y="0px"
                                 viewBox="0 0 112.18 122.88"
                                 xml:space="preserve">
                                <g>
                                    <path class="st0" d="M49.19,60.56l62.98,60.56V0L49.19,60.56L49.19,60.56z M0,122.88h35.53V0.05H0V122.88L0,122.88z"/>
                                </g>
                            </svg>
                    </button>
                </template>

                <template class="js-plyr-next">
                    <button type="button"
                            class="plyr__controls__item plyr__control"
                            x-on:click="component.playlist.next()"
                    >
                        <svg id="Layer_1"
                             xmlns="http://www.w3.org/2000/svg"
                             xmlns:xlink="http://www.w3.org/1999/xlink"
                             x="0px"
                             y="0px"
                             viewBox="0 0 112.18 122.88"
                             xml:space="preserve">
                            <g>
                                <path class="st0" d="M62.98,60.56L0,121.12V0L62.98,60.56L62.98,60.56z M112.18,122.88H76.65V0.05h35.53V122.88L112.18,122.88z"/>
                            </g>
                        </svg>
                    </button>
                </template>

                <template class="js-plyr-download">
                    <button type="button"
                            class="plyr__controls__item plyr__control"
                            x-on:click="component.download()"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg"
                             shape-rendering="geometricPrecision"
                             text-rendering="geometricPrecision"
                             image-rendering="optimizeQuality"
                             fill-rule="evenodd"
                             clip-rule="evenodd"
                             viewBox="0 0 512 501.59">
                            <path d="M15.47 366.69h481.06c8.51 0 15.47 6.96 15.47 15.47v103.96c0 8.51-6.96 15.47-15.47 15.47H15.47C6.96 501.59 0 494.63 0 486.12V382.16c0-8.51 6.96-15.47 15.47-15.47zM159.6 158.41h50.98V15.72c0-4.75 2.28-8.92 5.95-11.8C219.61 1.51 223.74 0 228.17 0h55.69c4.43 0 8.55 1.51 11.61 3.93 3.67 2.88 5.97 7.07 5.97 11.79v142.69h50.96c4.89 0 8.85 3.96 8.85 8.85 0 2.15-.77 4.13-2.05 5.66l-97.02 136.29c-2.83 3.97-8.34 4.9-12.31 2.07a8.694 8.694 0 0 1-2.13-2.15l-95.4-136.83c-2.79-4.01-1.79-9.52 2.21-12.3a8.823 8.823 0 0 1 5.05-1.59z"/>
                        </svg>
                    </button>
                </template>

                <template class="js-plyr-share">
                    <button type="button"
                            class="plyr__controls__item plyr__control"
                            x-on:click="component.share()"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg"
                             shape-rendering="geometricPrecision"
                             text-rendering="geometricPrecision"
                             image-rendering="optimizeQuality"
                             fill-rule="evenodd"
                             clip-rule="evenodd"
                             viewBox="0 0 469 511.53">
                            <path fill-rule="nonzero" d="M143.57 91.42h273.27c28.7 0 52.16 23.46 52.16 52.16v315.79c0 28.57-23.58 52.16-52.16 52.16H143.57c-28.69 0-52.15-23.47-52.15-52.16V143.58c0-28.72 23.44-52.16 52.15-52.16zm122.42 169.95c-9.85 13.65-30.59-1.26-20.8-14.94l18.33-25.47a59.675 59.675 0 0 1 17.1-15.96 60.646 60.646 0 0 1 22.02-8.22c16.4-2.67 32.32 1.53 44.79 10.49 12.47 8.98 21.51 22.72 24.19 39.12a60.594 60.594 0 0 1-.79 23.49 59.474 59.474 0 0 1-9.68 21.29l-18.32 25.47c-9.83 13.67-30.61-1.28-20.77-14.95l18.3-25.46c2.71-3.76 4.55-7.92 5.55-12.2 1.04-4.45 1.17-9.06.45-13.51-1.55-9.47-6.73-17.37-13.86-22.5-7.14-5.14-16.28-7.53-25.73-5.98-4.45.73-8.77 2.32-12.67 4.72a34.15 34.15 0 0 0-9.8 9.14l-18.31 25.47zm21.12 6.53c9.9-13.61 30.51 1.27 20.71 14.95l-34.04 51.43c-9.84 13.58-30.49-1.29-20.72-14.94l34.05-51.44zm6.99 74.15c9.85-13.67 30.61 1.28 20.78 14.95l-17.97 24.98c-4.74 6.58-10.59 11.94-17.11 15.96a60.398 60.398 0 0 1-22.02 8.22c-16.4 2.67-32.31-1.53-44.78-10.49-12.47-8.97-21.51-22.72-24.19-39.12a60.45 60.45 0 0 1 .78-23.46 59.833 59.833 0 0 1 9.69-21.27l18.01-25.09c9.87-13.59 30.54 1.35 20.75 14.99l-17.98 24.99a33.93 33.93 0 0 0-5.56 12.19 34.893 34.893 0 0 0-.43 13.5l.01.07c1.54 9.43 6.71 17.32 13.84 22.44 7.13 5.13 16.24 7.53 25.69 6l.07-.02c4.44-.73 8.76-2.32 12.63-4.71 3.74-2.3 7.1-5.37 9.81-9.14l17.98-24.99zm-257.52 8.77c0 10.1-8.19 18.29-18.29 18.29S0 360.92 0 350.82V52.16C0 23.44 23.44 0 52.16 0h273.26c10.1 0 18.29 8.19 18.29 18.29s-8.19 18.29-18.29 18.29H52.16c-8.54 0-15.58 7.04-15.58 15.58v298.66zM416.84 128H143.57c-8.53 0-15.57 7.04-15.57 15.58v315.79c0 8.52 7.06 15.58 15.57 15.58h273.27c8.59 0 15.58-6.99 15.58-15.58V143.58c0-8.52-7.06-15.58-15.58-15.58z"/>
                        </svg>

                        <span class="js-tooltip">copied!</span>
                    </button>
                </template>
            </ul>
        </div>
    </div>
</x-app-layout>
