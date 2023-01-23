<x-app-layout>
    <h1 class="mb-4 text-4xl text-center font-extrabold text-gray-900 md:text-5xl lg:text-6xl pt-8">{{ $website->getTitle() }}</h1>

    @foreach($website->getVideoProvider()->getBoards() as $board)
        {{ $board->getCode() }}
    @endforeach
</x-app-layout>
