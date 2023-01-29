<div class="absolute top-0 w-auto text-4xl text-center items-center font-semibold text-gray-900 pt-2" style="left: 50%; transform: translate(-50%)">
    @foreach($breadcrumbs->generate() as $item)/&hairsp;<a class="underline" href=" {{$item['url']}} ">{{ $item['title'] }}</a>&hairsp;@endforeach
</div>
