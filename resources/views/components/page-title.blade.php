@php /** @var \App\Models\Meta $meta */ @endphp

<div class="w-auto text-2xl pt-2 text-center items-center font-semibold text-gray-900">
    @foreach($meta->breadcrumbs() as $item)
        /&#8239;<a class="underline" href=" {{$item['url']}} ">{{ $item['title'] }}</a>&#8239;
    @endforeach
</div>
