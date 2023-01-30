<div class="absolute top-0 w-auto text-2xl md:text-4xl pt-3 md:pt-2 text-center items-center font-semibold text-gray-900" style="left: 50%; transform: translate(-50%)">
    @foreach($breadcrumbs->generate() as $item)/&#8239;<a class="underline" href=" {{$item['url']}} ">{{ $item['title'] }}</a>&#8239;@endforeach
</div>
