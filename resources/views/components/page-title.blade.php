<div class="absolute top-0 w-auto text-2xl md:text-4xl text-center items-center font-extrabold text-gray-900 pt-2" style="left: 50%; transform: translate(-50%)">
    @foreach($breadcrumbs->generate() as $item)/&nbsp;<a class="underline" href=" {{$item['url']}} ">{{ $item['title'] }}</a>&nbsp;@endforeach
</div>
