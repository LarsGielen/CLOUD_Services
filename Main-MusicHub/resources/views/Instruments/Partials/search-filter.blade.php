<form method="post" action="{{ route('instruments.filter') }}">
    @csrf

    <div class="flex gap-4 bg-white shadow-sm rounded-lg p-4">
        <div class="grow">
            <x-input-label for="instrumentFamily" value="InstrumentFamily" class="text-xl"/>
            <x-combobox id="instrumentFamily" name="instrumentFamily" submitOnSelect="true" class="w-full">
                <x-slot name="Content">
                    <option value="All"
                    <?php echo ($selectedFilters['instrumentFamily'] == 'All') ? 'selected' : ''; ?>>
                        all
                    </option>
                    <option value="Strings"
                    <?php echo ($selectedFilters['instrumentFamily'] == 'Strings') ? 'selected' : ''; ?>>
                        strings
                    </option>
                    <option value="Woodwind"
                    <?php echo ($selectedFilters['instrumentFamily'] == 'Woodwind') ? 'selected' : ''; ?>>
                        woodwind
                    </option>
                    <option value="Brass"
                    <?php echo ($selectedFilters['instrumentFamily'] == 'Brass') ? 'selected' : ''; ?>>
                        brass
                    </option>
                    <option value="Percussion"
                    <?php echo ($selectedFilters['instrumentFamily'] == 'Percussion') ? 'selected' : ''; ?>>
                        percussion
                    </option>
                    <option value="Electronic"
                    <?php echo ($selectedFilters['instrumentFamily'] == 'Electronic') ? 'selected' : ''; ?>>
                        electronic
                    </option>
                </x-slot>
            </x-combobox>
        </div>
        
        <div class="grow">   
            <x-input-label for="instrumentType" value="InstrumentType" class="text-xl"/>     
            <x-combobox id="instrumentType" name="instrumentType" class="w-full lowercase" submitOnSelect="true">
                    <x-slot name="Content">
                    <option value="All"
                    <?php echo ($selectedFilters['instrumentType'] == 'All') ? 'selected' : ''; ?>>
                        all
                    </option>
                    @foreach ($filteredinstrumentTypes as $instrumentType)
                    <option value="{{$instrumentType->name}}" class="lowercase"
                    <?php echo ($selectedFilters['instrumentType'] == $instrumentType->name) ? 'selected' : ''; ?>>
                        {{$instrumentType->name}}
                    </option>
                    @endforeach
                </x-slot>
            </x-combobox>
        </div>

        <div class="grow">
            <x-input-label for="condition" value="Condition" class="text-xl"/>
            <x-combobox id="condition" name="condition" class="w-full" submitOnSelect="true">
                <x-slot name="Content">
                <option value="All"
                    <?php echo ($selectedFilters['condition'] == 'All') ? 'selected' : ''; ?>>
                        all
                    </option>
                    <option value="NEW"
                    <?php echo ($selectedFilters['condition'] == 'NEW') ? 'selected' : ''; ?>>
                        new
                    </option>
                    <option value="USED"
                    <?php echo ($selectedFilters['condition'] == 'USED') ? 'selected' : ''; ?>>
                        used
                    </option>
                    <option value="OLD"
                    <?php echo ($selectedFilters['condition'] == 'OLD') ? 'selected' : ''; ?>>
                        old
                    </option>
                </x-slot>
            </x-combobox>
        </div>        
    </div>

    <div class="flex gap-6">
        <div class="grow flex gap-12 my-4 bg-white shadow-sm rounded-lg p-4">
            <div class="grow">
                <x-input-label for="min" value="Minimum price:" class="text-xl"/>
                <x-text-input id="min" name="min" type="number" value="{{$selectedFilters['min']}}" class="w-full"/>
            </div>

            <div class="grow">
                <x-input-label for="max" value="Maximum price:" class="text-xl"/>
                <x-text-input id="max" name="max" type="number" value="{{$selectedFilters['max']}}" class="w-full"/>
            </div>
        </div>

        <div class="grow flex gap-12 my-4 bg-white shadow-sm rounded-lg p-4">
            <div class="grow">
                <x-input-label for="sellLocation" value="Sell Location:" class="text-xl"/>
                <x-text-input id="sellLocation" name="sellLocation" type="text" value="{{$selectedFilters['sellLocation']}}" class="w-full"/>
            </div>
            <div class="grow">
                <x-input-label for="sellerUsername" value="Seller Username:" class="text-xl"/>
                <x-text-input id="sellerUsername" name="sellerUsername" type="text" value="{{$selectedFilters['sellerUsername']}}"  class="w-full"/>
            </div>
        </div>
    </div>
    
    <div class="flex">
        <x-secondary-button type="submit" class="grow">
            <b class="grow">Apply filters</b>
        </x-secondary-button>
    </div>

</form>