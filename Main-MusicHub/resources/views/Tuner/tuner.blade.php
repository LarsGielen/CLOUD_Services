<x-app-layout>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/paho-mqtt/1.0.1/mqttws31.js" type="text/javascript"></script>
    <script src="{{ asset('/js/Tuner/TunerView.js') }}"></script>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ "Tuner" }}
        </h2>
    </x-slot>

    <div class="bg-white shadow-sm sm:rounded-lg mx-12 p-6 my-4">
        <x-input-label for="deviceNameInput" value="Device name:" class="text-xl"/>
        <div class="flex gap-4">
            <x-text-input id="deviceNameInput" class="w-full" type="text"></x-text-input>
            <x-secondary-button id="setDeviceBtn">{{ "Subscribe" }}</x-secondary-button>
        </div>
        <p id="connectedDeviceOutput"></p>
    </div>

    <div class="my-40">
        <p id="noteOutput" class="w-full text-9xl text-center"></p>
        <p id="pitchOutput" class="w-full text-5xl text-center"></p>
    </div>

</x-app-layout>
