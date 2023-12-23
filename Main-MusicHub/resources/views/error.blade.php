<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex flex-col items-center p-6">
                    <div class="p-6 text-gray-900">
                        {{ $message }}
                    </div>

                    <a href="{{ route('home') }}">
                        <x-primary-button class="">
                            {{ ('Return to home') }}
                        </x-primary-button>    
                    </a>

                </div>
            </div>
        </div>
    </div>
    
</x-app-layout>
