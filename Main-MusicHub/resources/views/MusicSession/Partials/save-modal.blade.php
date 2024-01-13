<x-modal name="saveMusicSheetModal" id="saveMusicSheetModal" focusable>
    <form method="post" id="saveSheetMusicForm" action="{{ route('sheetmusic.create')  }}">
        @csrf
        <div class="flex flex-col gap-4 items-center m-6">
            <div class="w-full">
                <x-input-label value="Title:" class="text-xl"/>
                <x-text-input id="titleInput" name="title" class="w-full" type="text"></x-text-input>
            </div>

            <input id="notationHiddenInput" name="notation" type="hidden"/>
            
            <x-primary-button id="saveMusicSheetBtn" type="submit">Save</x-primary-button>        
        </div>
    </form>
    
    <script src="{{ asset('/js/MusicSession/MusicSessionSaveModal.js') }}"></script>
    <script>initSaveMusicSheetModal()</script>
</x-modal>