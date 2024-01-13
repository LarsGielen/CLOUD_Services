<x-modal name="createLocationModal" id="createLocationModal" focusable>

    <div class="flex flex-col gap-4 items-center m-6">
        <div class="w-full">
            <x-input-label value="Location name:" class="text-xl"/>
            <x-text-input id="locationNameInput" class="w-full" type="text"></x-text-input>
        </div>

        <div class="w-full">
            <x-input-label value="Location discription:" class="text-xl"/>
            <x-text-input id="locationDiscriptionInput" class="w-full" type="text"></x-text-input>
        </div>

        <div class="w-full">
            <x-input-label value="Location address:" class="text-xl"/>
            <x-text-input id="locationAddressInput" class="w-full" type="text"></x-text-input>
        </div>

        <div class="w-full">
            <x-input-label value="Location image url:" class="text-xl"/>
            <x-text-input id="locationImageUrlInput" class="w-full" type="text"></x-text-input>
        </div>
        
        <x-primary-button id="createNewLocationBtn" type="submit">Create</x-primary-button>        
    </div>

    <script src="{{ asset('/js/Events/CreateLocationModalView.js') }}"></script>
    <script>initCreateLocationModal("{{ $url }}")</script>
    
</x-modal>