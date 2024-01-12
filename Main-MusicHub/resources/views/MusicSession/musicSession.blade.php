<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/abcjs@6.2.3/dist/abcjs-basic-min.min.js"></script>
    <script src="{{ asset('/js/MusicSession/MusicSessionSocketClient.js') }}"></script>
    <script src="{{ asset('/js/MusicSession/MusicSessionView.js') }}"></script>
    <script> window.onload = function() { initWebsocket("{{ $url }}"); } </script>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ "Music Session" }}
        </h2>
    </x-slot>

    <div id="joinView">
        <div class="bg-white shadow-sm sm:rounded-lg mx-12 p-6 my-4">
            <x-input-label for="roomNameInput" value="Room name:" class="text-xl"/>
            <div class="flex gap-4">
                <x-text-input id="roomNameInput" class="w-full" type="text">Start conversion</x-text-input>
                <x-secondary-button id="joinBtn">{{ "Join" }}</x-secondary-button>
            </div>
        </div>
    </div>

    <div id="sessionView">
        <div class="bg-white shadow-sm sm:rounded-lg mx-12 p-6 my-4 flex flex-col gap-4">
            <div class="flex gap-4 items-center">
                <x-secondary-button id="leaveBtn" class="w-20">{{ "Leave" }}</x-secondary-button>
                <p id="roomName"></p>
            </div>
            <div class="flex gap-4">
                <div class="w-full">
                    <textarea id="notationInput" class="w-full"></textarea>
                    <div id="notationErrors"></div>
                </div>
                <div id="notationCanvas" class="w-full"></div>
            </div>
        </div>
    </div>

</x-app-layout>
