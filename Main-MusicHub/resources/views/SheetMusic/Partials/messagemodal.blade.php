<x-modal name="messageModal" id="messageModal" focusable>
    <div class="flex flex-col gap-1 items-center m-6">
        
        <h1 id="sendMessageText"></h1>

        <x-text-input id="messageText" class="w-full" type="text">Start conversion</x-text-input>

        <x-primary-button id="sendMessageButton" x-data="" x-on:click.prevent="$dispatch('close-modal', 'messageModal')">
            Send
        </x-primary-button>        
    </div>
</x-modal>

<script src="{{ asset('/js/gRPC-MessageService/GrpcMessageClient.js') }}" ></script>

<script>
    document.querySelector('#openModalButton').addEventListener('click', () => {

        document.querySelector('#sendMessageText').textContent = "Send message to " + "{{ $SheetMusic->username }}";
        document.querySelector('#messageText').value = "";
        window.dispatchEvent(new CustomEvent('open-modal', { detail: 'messageModal' }));
    });

    document.querySelector('#sendMessageButton').addEventListener('click', () => {
        GrpcMessageClient.sendMessageToUser (
            "{{ $messageServerUrl }}",
            "{{ auth()->user()->id }}",
            "{{ auth()->user()->name }}",
            "{{ $SheetMusic->userID }}",
            document.querySelector('#messageText').value
        );
    });
</script>