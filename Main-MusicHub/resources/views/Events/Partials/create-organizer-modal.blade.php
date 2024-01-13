<x-modal name="createOrganizerModal" id="createOrganizerModal" focusable>

    <div class="flex flex-col gap-4 items-center m-6">
        <div class="w-full">
            <x-input-label value="Organizer name:" class="text-xl"/>
            <x-text-input id="organizerNameInput" class="w-full" type="text"></x-text-input>
        </div>

        <div class="w-full">
            <x-input-label value="Organizer discription:" class="text-xl"/>
            <x-text-input id="OrganizerDiscriptionInput" class="w-full" type="text"></x-text-input>
        </div>

        <div class="w-full">
            <x-input-label value="Contact person email:" class="text-xl"/>
            <x-text-input id="OrganizerContactPersonInput" class="w-full" type="text"></x-text-input>
        </div>

        <div class="w-full">
            <x-input-label value="Organizer image url:" class="text-xl"/>
            <x-text-input id="OrganizerImageUrlInput" class="w-full" type="text"></x-text-input>
        </div>
        
        <x-primary-button id="createNewOrganizerBtn" type="submit">Create</x-primary-button>        
    </div>

    <script src="{{ asset('/js/Events/CreateOrganizerModalView.js') }}"></script>
    <script>initCreateOrganizerModal("{{ $url }}")</script>
</x-modal>
