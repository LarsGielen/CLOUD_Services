<x-app-layout>

    <a href="{{ route('events.index') }}">
        <x-primary-button class="mt-12 mx-12">
            {{ ('Back to search') }}
        </x-primary-button>
    </a>

    <div class="bg-white shadow-sm sm:rounded-lg p-6 mx-12 my-4">
        <div class="flex justify-end gap-4">
            <h1 class="text-3xl font-bold flex-grow">{{ $event->name }}</h1>
            @if($bookedByUser == null)
            <b class="text-3xl font-bold text-red-500">Get for €{{ $event->ticketPrice }}</b>
            @else   
            <b class="text-3xl font-bold text-green-500">You have booked {{ $bookedByUser->ticketAmount }} seats</b>
            <form method="post" action="{{ route('events.cancelbooking')}}">
                @csrf
                <input name="bookingID" type="hidden" value="{{ $bookedByUser->id }}"/>
                <x-primary-button><p class="text-red-400">Cancel Booking</p></x-primary-button>
            </form>
            @endif
            <x-primary-button class="flex-none" x-data="" x-on:click.prevent="$dispatch('open-modal', 'getTicketModal')">Get Tickets</x-primary-button>
        </div>
        <br>
        <div class="flex gap-4">
            <div>
                <img class="object-cover size-56 rounded-md" src="{{ $event->imageURL }}">
            </div>
            <div class="flex flex-col">
                <div class="grow">
                    <h2 class="text-xl font-semibold">Event Information</h2>
                    <p> Remaining seats: {{ $event->remainingSeats }} </p>
                    <p> location name:             
                        <a class="underline text-blue-400 hover:text-blue-800" href="{{ route('events.show.location', ['id' => $event->location->id]) }}">
                            {{ $event->location->name }} 
                        </a>
                    </p>
                    <p> address:             
                        {{ $event->location->address }} 
                    </p>
                    <p> date: {{ $event->dateTime->full }} </p>
                </div>
                <div>
                    <h2 class="text-xl font-semibold">Organisation Information</h2>
                    <p>name:             
                        <a class="underline text-blue-400 hover:text-blue-800" href="{{ route('events.show.organizer', ['id' => $event->organizer->id]) }}">
                            {{ $event->organizer->name }}
                        </a>
                    </p>
                    <p>Email contact person: {{ $event->organizer->contactPerson }}</p>
                </div>
            </div>
        </div>
        <br>
        <p class="font-bold text-xl"> Description:</p>       
        <p> {{ $event->description }} </p> 
    </div>

    @include('Events.Partials.getTicketModal')
</x-app-layout>