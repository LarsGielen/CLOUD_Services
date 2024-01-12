@if (!empty($userInstrumentPosts))
<div class="mx-12 my-6">
    <h1 class="text-3xl font-bold flex-grow">Your instruments for sale</h1>
    <div class="my-6 grid grid-cols-3 gap-6">
    @foreach ($userInstrumentPosts as $instrumentPost)
        <x-list-item
            imageURL="https://placekitten.com/300/200"
            title="{{$instrumentPost->title}}"
            info="Price: €{{$instrumentPost->price}}"
            buttonText="Details"
            buttonRef="{{ route('instruments.show', ['id' => $instrumentPost->id]) }}"
        />
    @endforeach
    </div>
</div>
@endif