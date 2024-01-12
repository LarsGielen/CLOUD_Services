<div class="grid grid-cols-3 gap-6">
    @foreach ($instrumentPosts as $instrumentPost)
        <x-list-item 
            imageURL="{{$instrumentPost->imageUrl}}"
            title="{{$instrumentPost->title}}"
            info="Price: €{{$instrumentPost->price}}"
            buttonText="Details"
            buttonRef="{{ route('instruments.show', ['id' => $instrumentPost->id]) }}"
        />
    @endforeach
</div>