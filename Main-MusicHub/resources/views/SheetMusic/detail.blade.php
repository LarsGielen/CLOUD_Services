<x-app-layout>

    <a href="{{ route('sheetmusic.index') }}">
        <x-primary-button class="mt-12 mx-12">
            {{ ('Back to search') }}
        </x-primary-button>
    </a>



    <div class="">
        <div class="bg-white shadow-sm sm:rounded-lg p-6 mx-12 my-4">
            <div class="flex justify-end gap-4">
                <div class="flex-grow">
                    <h1 class="text-3xl font-bold ">{{ $SheetMusic->musicTitle }}</h1>
                    <b> by {{ $SheetMusic->username }}</b>
                </div>
                <x-primary-button class="flex-none">
                    {{ ('Contact componist') }}
                </x-primary-button>
                <x-primary-button class="flex-none" x-data="" x-on:click.prevent="$dispatch('open-modal', 'getPDFModal')">
                    {{ ('Download pdf') }}
                </x-primary-button>
            </div>
        </div>

        <div class="bg-white shadow-sm sm:rounded-lg p-6 mx-12 my-4">
            @include('SheetMusic.Partials.musicnotation')
        </div>
    </div>


    <div class="mx-12 my-6">
        <h1 class="text-3xl font-bold flex-grow">Other sheet music from this user</h1>
        <div class="my-6 grid grid-cols-3 gap-6">
        @foreach ($sheetMusicfromComposer as $sheetMusicFromComposer)
        @if ($sheetMusicFromComposer->id != $SheetMusic->id)
            <x-list-item 
                imageURL=""
                title="{{ $sheetMusicFromComposer->musicTitle }}" 
                buttonText="Details"
                buttonRef="{{ route('sheetmusic.show', ['id' => $sheetMusicFromComposer->id]) }}"
            >
                <x-slot name="info">
                    <div>
                        <p>componist: {{ $sheetMusicFromComposer->username }}</p>
                    </div>
                </x-slot>
            </x-list-item>
        @endif
        @endforeach
        </div>
    </div>

    @include('SheetMusic.Partials.pdfmodal')

</x-app-layout>