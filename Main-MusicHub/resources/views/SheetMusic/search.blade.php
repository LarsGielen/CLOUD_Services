<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ "Sheet Music" }}
        </h2>
    </x-slot>

    @include('SheetMusic.Partials.search-filter')
    @include('SheetMusic.Partials.grid')

</x-app-layout>
