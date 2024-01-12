<x-modal name="messageModal" id="messageModal" focusable>
    <div class="flex flex-col gap-1 items-center m-6">
        
        <h1 id="sendMessageText"></h1>

        <x-text-input id="messageText" class="w-full" type="text">Start conversion</x-text-input>

        <x-primary-button id="sendMessageButton" x-data="" x-on:click.prevent="$dispatch('close-modal', 'messageModal')">
            Send
        </x-primary-button>        
    </div>
</x-modal>

<script src="{{ asset('/js/Messages/GrpcMessageClient.js') }}" ></script>
<script src="{{ asset('/js/Instruments/InstumentMessageModal.js') }}" ></script>

<script>MessageModalInit("{{ $messageServerUrl }}","{{ auth()->user()->id }}","{{ auth()->user()->name }}","{{ $post->seller->userID }}", "{{$post->seller->userName }}")</script>