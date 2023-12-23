<x-app-layout>

    <a href="{{ url()->previous() }}">
        <x-primary-button class="mt-12 mx-12">
            {{ ('Back') }}
        </x-primary-button>
    </a>

    <div class="bg-white shadow-sm sm:rounded-lg p-6 mx-12 my-4">
        <div class="flex justify-end gap-4">
            <h1 class="text-3xl font-bold flex-grow">{{ $location->name }}</h1>
        </div>
        <br>
        <div class="flex gap-4">
            <div>
                <img class="object-cover size-56 rounded-md" src="{{ $location->imageURL }}">
            </div>
            <div class="flex flex-col">
                <div class="grow">
                    <h2 class="text-xl font-semibold">Location Information</h2>
                    <p>address: {{ $location->address }}</p>
                </div>
            </div>
        </div>
        <br>
        <p class="font-bold text-xl"> Description:</p>       
        <p> {{ $location->description }} </p> 
    </div>

    <div class="mx-12 my-6">
        <h1 class="text-3xl font-bold flex-grow">Events at this location</h1>
        <div class="my-6 grid grid-cols-3 gap-6">
        @foreach ($events as $event)
            <x-list-item 
                imageURL="{{ $event->imageURL }}"
                title="{{ $event->name }}" 
                buttonText="Details"
                buttonRef="{{ route('events.show.event', ['id' => $event->id]) }}"
            >
                <x-slot name="info">
                    <div>
                        <p>Price: €{{ $event->ticketPrice }}</p>
                        <p>Remaining seats: {{$event->remainingSeats}}</p>
                    </div>
                </x-slot>
            </x-list-item>
        @endforeach
        </div>
    </div>
</x-app-layout>