<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ "Instruments" }}
        </h2>
    </x-slot>

    @include('Instruments.partials.search-filter')
    @include('Instruments.partials.grid')

</x-app-layout>
