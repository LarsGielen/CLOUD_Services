<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ "Events" }}
        </h2>
    </x-slot>

    @include('Events.Partials.search-filter')
    @include('Events.Partials.grid')
    
</x-app-layout>
