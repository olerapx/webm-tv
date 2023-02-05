@php /** @var \App\Models\Breadcrumbs $breadcrumbs */ @endphp

<div class="absolute top-0 w-auto text-2xl pt-2 text-center items-center font-semibold text-gray-900" style="left: 50%; transform: translate(-50%)">
    @foreach($breadcrumbs->generate() as $item)/&#8239;<a class="underline" href=" {{$item['url']}} ">{{ $item['title'] }}</a>&#8239;@endforeach
</div>

@section('title', $breadcrumbs->generate()->reduce(function ($carry, $item) {
    return $carry . '/' . $item['title'];
}))
