<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ "Instruments" }}
        </h2>
    </x-slot>

    <div class="mx-12 py-6 flex flex-col gap-6">
        <x-primary-button class="w-full" id="createPostButton"><p class="w-full text-center">Create new post</p></x-primary-button>
    
        @include('Instruments.partials.search-filter')
        <br>
        @include('Instruments.partials.grid')
    </div>

    @include('Instruments.Partials.create-post-modal')
</x-app-layout>
