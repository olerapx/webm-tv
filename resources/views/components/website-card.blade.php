<div class="my-1 px-4 w-1/2 md:w-1/3 lg:my-4 lg:px-4 lg:w-1/4">
    <div class="rounded-lg shadow-md hover:shadow-lg hover:border-gray-600 aspect-square p-4">
        <div class="rounded-full bg-slate-50 aspect-square shadow-inner p-4">
            <a href="{{ $url()  }}">
                {!! $svg() !!}
            </a>
        </div>

        <header class="flex items-center text justify-between leading-tight p-2 md:p-4">
            <h2 class="text-lg">
                <a class="no-underline hover:underline text-black" href="{{ $url() }}">{{ $website->getTitle() }}</a>
            </h2>
        </header>
    </div>
</div>
