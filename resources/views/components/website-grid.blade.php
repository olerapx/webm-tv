@php /** @var \App\Contracts\WebsiteProvider $websiteProvider */ @endphp

<div class="container my-12 mx-auto px-4 md:px-12">
    <div class="flex flex-wrap -mx-1 lg:-mx-4 justify-center">
        @foreach($websiteProvider->getAll() as $website)
            <x-website-card :website="$website" />
        @endforeach
    </div>
</div>
