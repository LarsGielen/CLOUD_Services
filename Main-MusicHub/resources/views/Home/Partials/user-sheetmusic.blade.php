
@if (!empty($userSheetMusic))
<div class="mx-12 my-6">
    <h1 class="text-3xl font-bold flex-grow">Your sheet music</h1>
    <div class="my-6 grid grid-cols-3 gap-6">
    @foreach ($userSheetMusic as $music)
        <x-list-item 
            imageURL=""
            title="{{ $music->musicTitle }}" 
            buttonText="Details"
            buttonRef="{{ route('sheetmusic.show', ['id' => $music->id]) }}"
        >
            <x-slot name="info">
                <div>
                    <p>componist: {{ $music->username }}</p>
                </div>
            </x-slot>
        </x-list-item>
    @endforeach
    </div>
</div>
@endif