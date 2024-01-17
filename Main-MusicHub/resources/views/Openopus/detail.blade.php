<x-app-layout>
    <a href="{{ route('openopus.index') }}">
        <x-primary-button class="mt-12 mx-12">
            Back to search
        </x-primary-button>
    </a>

    <div class="bg-white shadow-sm sm:rounded-lg p-6 mx-12 my-4">
        <h1 class="text-3xl font-bold flex-grow">{{ $composer->complete_name }}</h1>

        <br>

        <div class="flex gap-4">
            <div>
                <img class="object-cover size-56 rounded-md" src="{{$composer->portrait}}">
            </div>
            <div class="flex flex-col">
                <div class="grow">
                    <h2 class="text-xl font-semibold">Composer Information</h2>
                    <p>Timer period: {{ $composer->epoch }}</p>
                    <p>birth date: {{ $composer->birth }}</p>
                    <p>death date: {{ $composer->death }}</p>
                </div>
            </div>
        </div>

        <br>
    </div>
    @if (!empty($works))
        <div class="mx-12 my-4">
            <h2 class="text-xl font-semibold">Popular works:</h2>
            <br>
            <div class="grid grid-cols-1 gap-6">
                @foreach ($works as $work)
                    <div class="bg-white shadow-sm sm:rounded-lg p-6">
                        <h2 class="font-semibold">{{ $work->title }}</h2>
                        <p>{{ $work->subtitle }}</p>
                        <p>{{ $work->genre }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</x-app-layout>
