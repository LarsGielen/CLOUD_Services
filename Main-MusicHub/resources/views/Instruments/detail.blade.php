<x-app-layout>

    <a href="{{ route('instruments.index') }}">
        <x-primary-button class="mt-12 mx-12">
            {{ ('Back to search') }}
        </x-primary-button>
    </a>

    <div class="bg-white shadow-sm sm:rounded-lg p-6 mx-12 my-4">
        <div class="flex justify-end gap-4">
            <h1 class="text-3xl font-bold flex-grow">{{ $post->title }}</h1>
            @if ($post->seller->userID == auth()->user()->id)

                <a href="{{ route('instruments.delete', ['id' => $post->id])}}"><x-primary-button><p class="text-red-400">Remove instrument</p></x-primary-button></a>
            @else
                <b class="text-3xl font-bold text-red-500">Buy for €{{ $post->price }}</b>
                <x-primary-button id="openModalButton" class="flex-none">Contact seller</x-primary-button>
            @endif
        </div>
        <br>
        <div class="flex gap-4">
            <div>
                <img class="object-cover size-56 rounded-md" src="{{$post->imageUrl}}">
            </div>
            <div class="flex flex-col">
                <div class="grow">
                    <h2 class="text-xl font-semibold">Instrument Information</h2>
                    <p> Type: {{ $post->type->name }} </p>
                    <p> Instrument family: {{ $post->type->family }} </p>
                    <p> Condation: {{ $post->condition }} </p>
                    <p> age: {{ $post->age }} years </p>
                </div>
                <div>
                    <h2 class="text-xl font-semibold">Seller Information</h2>
                    <p>Username: {{ $post->seller->userName }}</p>
                    <p>Email: {{ $post->seller->email }}</p>
                </div>
            </div>
            <div>

            </div>
        </div>
        <br>
        <p class="font-bold text-xl"> Description:</p>       
        <p> {{ $post->description }} </p> 
    </div>

    <div class="mx-12 my-6">
        <h1 class="text-3xl font-bold flex-grow">Other instruments from this type</h1>
        <div class="my-6 grid grid-cols-3 gap-6">
        @foreach ($post->type->instrumentsForSale as $instrumentPost)
            @if($instrumentPost->id !== $post->id)
            <x-list-item 
                imageURL="{{$instrumentPost->imageUrl}}"
                title="{{$instrumentPost->title}}"
                info="Price: €{{$instrumentPost->price}}"
                buttonText="Details"
                buttonRef="{{ route('instruments.show', ['id' => $instrumentPost->id]) }}"
            />
            @endif
        @endforeach
        </div>
    </div>

    <div class="mx-12 my-6">
        <h1 class="text-3xl font-bold flex-grow">Other instruments from this seller</h1>
        <div class="my-6 grid grid-cols-3 gap-6">
        @foreach ($post->seller->instrumentsForSale as $instrumentPost)
            @if($instrumentPost->id !== $post->id)
            <x-list-item
                imageURL="{{$instrumentPost->imageUrl}}"
                title="{{$instrumentPost->title}}"
                info="Price: €{{$instrumentPost->price}}"
                buttonText="Details"
                buttonRef="{{ route('instruments.show', ['id' => $instrumentPost->id]) }}"
            />
            @endif
        @endforeach
        </div>
    </div>

    @include('Instruments.Partials.messageModal')
</x-app-layout>