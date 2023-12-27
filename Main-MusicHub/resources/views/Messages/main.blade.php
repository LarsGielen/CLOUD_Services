<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ "Messages" }}
        </h2>
    </x-slot>

    @include('Messages.Partials.messagelist')
    @include('Messages.Partials.messagemodal')
</x-app-layout>
