<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ "Tuner" }}
        </h2>
    </x-slot>

    <div class="bg-white shadow-sm sm:rounded-lg mx-12 p-6 my-4">
        <x-input-label for="deviceNameInput" value="Device name:" class="text-xl"/>
        <div class="flex gap-4">
            <x-text-input id="deviceNameInput" class="w-full" type="text"></x-text-input>
            <x-secondary-button id="joinBtn">{{ "Set" }}</x-secondary-button>
        </div>
    </div>

    <p class="w-full text-9xl my-52 text-center">G</p>

</x-app-layout>
