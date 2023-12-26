<form method="post" action="{{ route('events.filter') }}" class="m-12">
    @csrf

    <div class="flex gap-4 bg-white shadow-sm rounded-lg p-4">
        <div class="grow">
            <x-input-label for="SortedBy" value="SortedBy:" class="text-xl"/>
            <x-combobox id="SortedBy" name="SortedBy" submitOnSelect="true" class="w-full">
                <x-slot name="Content">
                    <option>None</option>
                    <option>Popular</option>
                    <option>Alphabetical</option>
                    <option>Price</option>
                    <option>Date</option>
                    @Auth
                    <option>My booked events</option>
                    @endAuth
                </x-slot>
            </x-combobox>
        </div>
    </div>

    <script>
        @if (isset($selectedFilter))
            var combobox = document.querySelector('#SortedBy');
            var options = combobox.querySelectorAll("option");

            for (var i = 0; i < options.length; i++) {
                if (options[i].textContent.trim() === @json($selectedFilter)) {
                    options[i].selected = true;
                    break;
                }
            }
        @endif
    </script>
</form>