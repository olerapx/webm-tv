<x-app-layout>
    <div class="max-w-2xl px-6 py-16 mx-auto space-y-12">
        <article class="space-y-8 dark:bg-gray-800 dark:text-gray-50">
            <div class="space-y-6">
                <h1 class="text-4xl font-bold md:tracking-tight md:text-5xl">{{ __('Getting usercode cookie for 2ch.hk') }}</h1>
            </div>

            <div class="space-y-6">
                <ul class="ml-4 text-lg space-y-4 list-disc">
                    <li>
                        <a rel="noopener noreferrer" target="_blank" href="https://2ch.hk/" class="underline">{{ __('Navigate to 2ch.hk.') }}</a>
                    </li>

                    <li>{{ __('Leave a post or a comment. Do not violate the rules.') }}</li>
                    <li>
                        {{ __('Enter the following in the URL (do not paste):') }}
                        <code class="bg-gray-800 shadow-2xl text-white p-1 rounded-md">javascript:prompt(1, document.cookie);</code>
                    </li>
                    <li> {{ __('Press ENTER.') }}</li>
                    <li>
                        {{ __('Copy the value corresponding to') }} <code class=" text-sm bg-gray-800 shadow-2xl text-white p-1 rounded-md">usercode_auth</code>.
                        <p class="mt-3 text-sm md:mt-0">{{ __('Example value: ') }} <code class="bg-gray-800 shadow-2xl text-white p-1 rounded-md">fabcabcabcabc123abc123123abc</code></p>
                    </li>
                    <li>{{ __('That\'s it! Now you have the access code.') }}</li>
                </ul>
            </div>
        </article>
    </div>
</x-app-layout>
