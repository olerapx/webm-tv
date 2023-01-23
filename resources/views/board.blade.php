<x-app-layout>
    <x-page-title title="{{ $website->getTitle() }} - {{ $board }}"/>

    <div class="flex w-full h-screen mt-8" x-data="{}" x-init="$dispatch('board-player-init', {element: $el})">
        <video
               controls
               preload="auto"
               class="js-plyr-video"
               data-website="{{ $website->getCode()->value }}"
               data-board="{{ $board }}">
        </video>

        <div class="plyr-playlist-wrapper">
            <ul class="js-plyr-playlist plyr-playlist">
                <template class="js-plyr-playlist-item-template">
                    <li class="playlist-item">
                        <a class="flex flex-col" x-on:click="$dispatch('board-playlist-select', {element: $el})">
                            <img class="plyr-miniposter" />
                            <span class="plyr-minititle"></span>
                        </a>
                    </li>
                </template>

                <template class="js-plyr-prev">
                    <button type="button"
                            class="plyr__controls__item plyr__control"
                            x-on:click="$dispatch('board-playlist-prev')"
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
                            x-on:click="$dispatch('board-playlist-next')"
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
            </ul>
        </div>
    </div>
</x-app-layout>
