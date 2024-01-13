<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ "Home" }}
        </h2>
    </x-slot>

@auth
    @include('Home.Partials.popular-events')
    @include('Home.Partials.user-events')
    @include('Home.Partials.user-instruments')
    @include('Home.Partials.user-sheetmusic')
@else
    <div class="py-4 mx-12">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 flex flex-col items-center">
                <p>You're not logged in. To see recommendations and personal items, you need to log in!</p>
                <a href="{{ route('login') }}"> <x-primary-button class="mt-12 mx-12"> {{ ('Login') }} </x-primary-button> </a>
            </div>
        </div>
    </div>
@endauth

</x-app-layout>
