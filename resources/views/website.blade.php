<x-app-layout>
    <h1 class="text-4xl text-center font-extrabold text-gray-900 md:text-5xl lg:text-6xl pt-8">{{ $website->getTitle() }}</h1>

    <div class="container my-12 mx-auto px-4 md:px-12">
        <div class="flex justify-end my-8">
            <div class="relative w-full lg:w-1/3 px-4" x-data="{}">
                <input type="search"
                       class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                       placeholder="Search boards..."
                       x-on:input="boardSearch.search($el)"
                       x-on:paste="boardSearch.search($el)"
                       x-init="boardSearch.search($el)"
                       required
                >

                <button type="submit"
                        class="absolute top-0 right-0 p-2.5 mr-4 text-sm font-medium text-white bg-blue-700 rounded-r-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>
            </div>
        </div>

        <div class="flex flex-wrap -mx-1 lg:-mx-4">
            @foreach($website->getVideoProvider()->getBoards() as $code => $title)
                <x-board-link code="{{ $code }}" title="{{ $title }}" :website="$website"/>
            @endforeach
        </div>
    </div>
</x-app-layout>
