<form method="post" action="{{ route('sheetmusic.filter') }}" class="m-12">
    @csrf

    <div class="flex gap-4 bg-white shadow-sm rounded-lg p-4">
        <div class="grow">
            <x-input-label for="Title" value="Seach by title:" class="text-xl"/>
            <div class="flex gap-4">
                <x-text-input id="title" name="title" type="text" value="{{ $searchTitle }}" class="w-full"/>
                <x-secondary-button type="submt">
                    {{ "Search" }}
                </x-secondary-button>
            </div>
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