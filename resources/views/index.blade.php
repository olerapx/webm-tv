<x-app-layout>
    <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
        @guest
            <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</a>
            <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Register</a>
        @endguest
    </div>

    <h1 class="mb-4 text-4xl text-center font-extrabold text-gray-900 md:text-5xl lg:text-6xl pt-8">{{ config('app.name', 'Laravel') }}</h1>

    <div class="container my-12 mx-auto px-4 md:px-12">
        <div class="flex flex-wrap -mx-1 lg:-mx-4">
            <x-website-card path="dvach" />
            <x-website-card path="dvach" />
            <x-website-card path="dvach" />
            <x-website-card path="dvach" />
            <x-website-card path="dvach" />
        </div>
    </div>
</x-app-layout>
