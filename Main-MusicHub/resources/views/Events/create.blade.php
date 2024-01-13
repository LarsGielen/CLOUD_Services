<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ "Create an event" }}
        </h2>
    </x-slot>

    <div class="flex flex-col py-6 px-12 gap-6">
        <a href="{{ route('events.index') }}">
            <x-primary-button class="">
                {{ ('Back to search') }}
            </x-primary-button>
        </a>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <form method="post" action="{{ route('events.create') }}" class="flex flex-col gap-4">
                    @csrf
        
                    <div>
                        <x-input-label for="name" value="Event Name:" class="text-xl"/>
                        <x-text-input name="name" type="text" value="" class="w-full"/> 
                    </div>
                    
                    <div>
                        <x-input-label for="description" value="Description:" class="text-xl"/>
                        <x-text-input name="description" type="text" value="" class="w-full"/> 
                    </div>
                    
                    <div>
                        <x-input-label for="locationID" value="Location:" class="text-xl"/>
                        <div class="flex gap-4">
                            <x-combobox id="locationID" name="locationID" class="flex-grow">
                                <x-slot name="Content"></x-slot>
                            </x-combobox>
                            <x-secondary-button id="openCreateNewLocationModalBtn">Create new</x-secondary-button>   
                        </div>
                    </div>
        
                    <div>
                        <x-input-label for="organizerID" value="Organizer:" class="text-xl"/>
                        <div class="flex gap-4">
                            <x-combobox id="organizerID" name="organizerID" class="flex-grow">
                                <x-slot name="Content"></x-slot>
                            </x-combobox>
                            <x-secondary-button id="openCreateNewOrganizerModalBtn">Create new</x-secondary-button>   
                        </div>
                    </div>
        
                    <div>
                        <x-input-label for="date" value="Date:" class="text-xl"/>
                        <x-text-input name="date" type="date" value="" class="w-full"/> 
                    </div>
        
                    <div>
                        <x-input-label for="time" value="Time:" class="text-xl"/>
                        <x-text-input name="time" type="time" value="" class="w-full"/> 
                    </div>
        
                    <div>
                        <x-input-label for="ticketPrice" value="TicketPrice:" class="text-xl"/>
                        <x-text-input name="ticketPrice" type="number" value="" class="w-full"/> 
                    </div>
        
                    <div>
                        <x-input-label for="seats" value="Seat amount:" class="text-xl"/>
                        <x-text-input name="seats" type="number" value="" class="w-full"/> 
                    </div>       
        
                    <div>
                        <x-input-label for="imageURL" value="Image URL:" class="text-xl"/>
                        <x-text-input name="imageURL" type="text" value="" class="w-full"/> 
                    </div>       
                    
                    <x-primary-button type="submit"><p class="w-full text-center">Create</p></x-primary-button>        
                </form>
            </div>
        </div>
    </div>

    <script src="{{ asset('/js/Events/CreateEventView.js') }}"></script>
    <script>initCreateEventView("{{ $url }}")</script>

    @include('Events.Partials.create-location-modal')
    @include('Events.Partials.create-organizer-modal')
</x-app-layout>