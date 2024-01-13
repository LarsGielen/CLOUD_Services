<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ "Events" }}
        </h2>
    </x-slot>

    <div class="flex flex-col gap-6 py-6 px-12">
        <a href="{{ route('events.createView') }}">
            <x-primary-button class="w-full">
                <p class="w-full text-center">Create New Event</p>
            </x-primary-button>
        </a>
    
        @include('Events.Partials.search-filter')
        @include('Events.Partials.grid')
    </div>
    
</x-app-layout>
