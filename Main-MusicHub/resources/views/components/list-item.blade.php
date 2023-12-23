@props(['title' => 'title', 'info' => '', 'imageURL' => null, 'buttonText' => 'Buy', 'buttonRef' => null, 'class' => ''])

<div class="bg-white shadow-sm sm:rounded-lg p-6 flex gap-6 {{$class}}">
    @if($imageURL)
    <div class="flex-none">
        <img class="object-cover size-48 rounded-md" src={{$imageURL}} alt="Electric Guitar">
    </div>
    @endif
    <div class="flex-grow flex flex-col">
        <div class="flex-grow">
            <h2 class="font-bold text-xl">
                {{ $title }}
            </h2>
            {{ $info }}
        </div>
        <div class="flex justify-end">
            <a href="{{ $buttonRef }}">
                <x-primary-button class="ms-3">
                    {{ $buttonText }}
                </x-primary-button>
            </a>
        </div>
    </div>
</div>