<div class="grid grid-cols-2 gap-6">
    @foreach ($composers as $composer)
        <x-list-item 
            imageURL="{{ $composer->portrait }}"
            title="{{ $composer->complete_name }}"
            info="Period: {{ $composer->epoch }}"
            buttonText="Details"
            buttonRef="{{ route('openopus.show', ['id' => $composer->id]) }}"
        />
    @endforeach
</div>