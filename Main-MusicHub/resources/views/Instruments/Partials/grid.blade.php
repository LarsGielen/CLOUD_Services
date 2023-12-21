<div class="m-12 grid grid-cols-3 gap-6">
    @foreach ($instrumentPosts as $instrumentPost)
        <x-list-item 
            imageURL="https://placekitten.com/300/200"
            title="{{$instrumentPost->title}}"
            info="Price: €{{$instrumentPost->price}}"
            buttonText="Details"
            buttonRef="{{ route('instruments.show', ['id' => $instrumentPost->id]) }}"
        />
    @endforeach
</div>