<div class="m-12 grid grid-cols-3 gap-6">
    @foreach ($SheetMusics as $sheetMusic)
    @if (is_object($sheetMusic))
        <x-list-item 
            imageURL=""
            title="{{ $sheetMusic->musicTitle }}" 
            buttonText="Details"
            buttonRef="{{ route('sheetmusic.show', ['id' => $sheetMusic->id]) }}"
        >
            <x-slot name="info">
                <div>
                    <p>componist: {{ $sheetMusic->username }}</p>
                </div>
            </x-slot>
        </x-list-item>
    @endif
    @endforeach
</div>