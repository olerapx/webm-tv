<nav x-data="{ showLogin: false }" class="bg-white border-b border-gray-100" @keydown.escape="showLogin = false">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('index') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>
            </div>

{{--            <div class="flex items-center">--}}
{{--                @auth--}}
{{--                    <x-dropdown align="right" width="48">--}}
{{--                        <x-slot name="trigger">--}}
{{--                            <button class="inline-flex items-center px-3 py-2 border border-transparent leading-4 font-medium rounded-md bg-white hover:text-gray-800 focus:outline-none transition ease-in-out duration-150">--}}
{{--                                <div>{{ Auth::user()->name }}</div>--}}

{{--                                <div class="ml-1">--}}
{{--                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">--}}
{{--                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />--}}
{{--                                    </svg>--}}
{{--                                </div>--}}
{{--                            </button>--}}
{{--                        </x-slot>--}}

{{--                        <x-slot name="content">--}}
{{--                            <x-dropdown-link :href="route('me')">{{ __('Me') }}</x-dropdown-link>--}}
{{--                            <form method="POST" action="{{ route('logout') }}">--}}
{{--                                @csrf--}}
{{--                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">{{ __('Log Out') }}</x-dropdown-link>--}}
{{--                            </form>--}}
{{--                        </x-slot>--}}
{{--                    </x-dropdown>--}}
{{--                @endauth--}}

{{--                @guest--}}
{{--                    <div align="right">--}}
{{--                        <a x-on:click.prevent="showLogin = true" href="" class="underline">Sign In</a>--}}
{{--                    </div>--}}
{{--                @endguest--}}
{{--            </div>--}}
        </div>
    </div>

{{--    <div :class="{'flex displaying': showLogin}"--}}
{{--         x-show="showLogin"--}}
{{--         @keydown.escape="showLogin = false"--}}
{{--         class="modal hidden">--}}
{{--        <div class="modal-box rounded-lg">--}}
{{--            <button class="absolute right-6 top-6 cursor-pointer rounded-full bg-gray-600 text-white w-6 h-6" x-on:click.prevent="showLogin = false">✕</button>--}}
{{--            <x-login/>--}}
{{--        </div>--}}
{{--    </div>--}}
</nav>
