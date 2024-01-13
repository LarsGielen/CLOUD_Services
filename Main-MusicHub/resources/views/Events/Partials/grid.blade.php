<div class="grid grid-cols-3 gap-6">
    @foreach ($events as $event)
    @if (is_object($event))

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
                    <p>Date: {{$event->dateTime->date}}</p>
                </div>
            </x-slot>
        </x-list-item>
    @endif
    @endforeach
</div>