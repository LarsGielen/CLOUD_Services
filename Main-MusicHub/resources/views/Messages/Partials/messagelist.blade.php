<div id="messages" class="py-12 mx-12 flex flex-col gap-2"></div>

<script src="{{ asset('/js/gRPC-MessageService/GrpcMessageClient.js') }}" ></script>
<script src="{{ asset('/js/Messages/MessageView.js') }}"></script>

<script>
    init('{{ $messageServerUrl }}', '{{ auth()->user()->id }}', '{{ auth()->user()->name }}')
    openStream();
</script>