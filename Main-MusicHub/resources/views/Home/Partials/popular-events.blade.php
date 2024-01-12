<div class="mx-12 my-6">
    <div class="flex items-center">
        <h1 class="text-3xl font-bold flex-grow">Popular events</h1>
        <x-primary-button class="">All Events</x-primary-button>
    </div>
    <div class="my-6 grid grid-cols-3 gap-6">
    @foreach ($popularEvents as $event)
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