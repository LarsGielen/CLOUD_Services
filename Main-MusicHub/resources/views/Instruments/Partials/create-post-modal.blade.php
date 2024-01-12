<form method="post" action="{{ route('instruments.create') }}">
    @csrf
    
    <x-modal name="createPostModal" id="createPostModal" focusable>

        <div class="flex flex-col gap-1 items-center m-6">
            
            <h1 id="sendMessageText"></h1>
            
            <div class="w-full">
                <x-input-label for="title" value="Title:" class="text-xl"/>
                <x-text-input id="title" name="title" class="w-full" type="text"></x-text-input>
            </div>
            
            <div class="w-full">
                <x-input-label for="description" value="Description:" class="text-xl"/>
                <x-text-input id="description" name="description" class="w-full" type="text"></x-text-input>
            </div>
            
            <div class="w-full">
                <x-input-label for="type" value="Type:" class="text-xl"/>
                <x-combobox id="type" name="type" class="w-full lowercase">
                    <x-slot name="Content" id="typeInputContent"></x-slot>
                </x-combobox>
            </div>
            
            <div class="w-full">
                <x-input-label for="age" value="Age:" class="text-xl"/>
                <x-text-input id="age" name="age" class="w-full" type="number"></x-text-input>
            </div>

            <div class="w-full">
                <x-input-label for="condition" value="Condition:" class="text-xl"/>
                <x-combobox id="condition" name="condition" class="w-full lowercase">
                    <x-slot name="Content">
                        <option value="NEW">New</option>
                        <option value="USED">Used</option>
                        <option value="OLD">Old</option>
                    </x-slot>
                </x-combobox>
            </div>

            <div class="w-full">
                <x-input-label for="price" value="Price:" class="text-xl"/>
                <x-text-input id="price" name="price" class="w-full" type="number"></x-text-input>
            </div>

            <div class="w-full">
                <x-input-label for="location" value="Location" class="text-xl"/>
                <x-text-input id="location" name="location" class="w-full" type="text"></x-text-input>
            </div>

            <div class="w-full">
                <x-input-label for="imageUrl" value="Image:" class="text-xl"/>
                <x-text-input id="imageUrl" name="imageUrl" class="w-full" type="text"></x-text-input>
            </div>
            
            <x-primary-button id="createButton" type="submit">Create</x-primary-button>        
        </div>

        <script src="{{ asset('/js/Instruments/InstrumentCreatePostModal.js') }}"></script>
        <script>createPostModalInit(@json($instrumentTypes))</script>
        
    </x-modal>

</form>
