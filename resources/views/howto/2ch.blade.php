<x-app-layout>
    <div class="max-w-2xl px-6 py-16 mx-auto space-y-12">
        <article class="space-y-8 dark:bg-gray-800 dark:text-gray-50">
            <div class="space-y-6">
                <h1 class="text-3xl text-center font-bold md:tracking-tight">{{ __('Getting usercode cookie for 2ch.hk') }}</h1>
            </div>

            <div class="space-y-6">
                <ol class="ml-4 text-lg space-y-4 list-decimal">
                    <li>
                        <a rel="noopener noreferrer" target="_blank" href="https://2ch.hk/" class="underline">{{ __('Navigate to 2ch.hk.') }}</a>
                    </li>

                    <li>
                        {{ __('Leave a post or a comment. Do not violate the rules.') }}
                    </li>

                    <li>
                        {{ __('Enter the following in the URL (do not paste):') }}
                        <code class="bg-gray-800 shadow-2xl text-white p-1 rounded-md">javascript:prompt(1, document.cookie);</code>
                    </li>

                    <li>
                        {{ __('Press ENTER.') }}
                    </li>

                    <li>
                        {{ __('Copy the value corresponding to') }} <code class=" text-sm bg-gray-800 shadow-2xl text-white p-1 rounded-md">usercode_auth</code>.
                        <p class="mt-3 text-sm md:mt-0">{{ __('Example value: ') }} <code class="bg-gray-800 shadow-2xl text-white p-1 rounded-md">fabcabcabcabc123abc123123abc</code></p>
                    </li>

                    <li>
                        {{ __('That\'s it! Now you have the access code.') }}
                    </li>
                </ol>
            </div>

            <div class="space-y-6 pt-6">
                <h2 class="text-2xl italic">{{ __('I\'ve entered the code, but there is black screen instead of videos. What do I do?') }}</h2>
            </div>

            <div class="space-y-6">
                <p class="text-lg">
                    {{ __('Make sure you enter the code on the same device you received in on.') }}
                    {{ __('To watch videos, you have to have the') }}
                    <code class=" text-sm bg-gray-800 shadow-2xl text-white p-1 rounded-md">usercode_auth</code>
                    {{ __('set on 2ch.hk itself.') }}
                </p>

                <p class="text-lg">
                    {{ __('If that did not help, your browser probably rejects using the cookie on 2ch.hk.') }}
                </p>

                <ul class="ml-4 text-lg space-y-4 list-disc">
                    <li>
                        {{ __('On Firefox, you should just disable the Tracking Protection for :title.', ['title' => config('app.name')]) }}
                        <a rel="noopener noreferer" target="_blank" class="underline" href="https://support.mozilla.org/ru/kb/uluchshennaya-zashita-ot-otslezhivaniya-firefox-dlya-kompyutera?redirectslug=uluchshennaya-zashita-ot-otslezhivaniya-v-firefox-&redirectlocale=ru">
                            {{ __('Learn how.') }}
                        </a>
                    </li>

                    <li>
                        {{ __('On Chromium-based browsers (Google Chrome, Edge):') }}
                        <ul class="ml-8 list-disc">
                            <li>
                                <a rel="noopener noreferrer" target="_blank" href="https://2ch.hk/" class="underline">{{ __('Navigate to 2ch.hk.') }}</a>
                            </li>

                            <li>
                                {{ __('Press F12 to open Developer Tools.') }}
                            </li>

                            <li>
                                {{ __('Go Application - Cookies, find the cookie and select "Secure".') }}
                            </li>
                        </ul>
                    </li>

                    <li>
                        {{ __('On Chrome Android, you may complete the previous steps using') }}
                        <a rel="noopener noreferrer" target="_blank" href="https://developer.chrome.com/docs/devtools/remote-debugging/" class="underline">{{ __('Remote Debugging.') }}</a>
                    </li>
                </ul>
            </div>
        </article>
    </div>
</x-app-layout>
