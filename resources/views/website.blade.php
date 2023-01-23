<x-app-layout>
    <h1 class="mb-4 text-4xl text-center font-extrabold text-gray-900 md:text-5xl lg:text-6xl pt-8">{{ $website->getTitle() }}</h1>

    <div class="container my-12 mx-auto px-4 md:px-12">
        <div class="flex flex-wrap -mx-1 lg:-mx-4">
            @foreach($website->getVideoProvider()->getBoards() as $code => $title)
                <x-board-link code="{{ $code }}" title="{{ $title }}" :website="$website" />
            @endforeach
        </div>
    </div>
</x-app-layout>
