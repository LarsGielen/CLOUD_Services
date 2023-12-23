<x-modal name="getTicketModal" :show="$errors->userDeletion->isNotEmpty()" focusable>
    <form 
        method="post" 
        action="{{ route('events.book')  }}" 
        id="ticketForm" 
        oninput="priceCalculation.value = (ticketAmount.valueAsNumber || 0) * {{ $event->ticketPrice }}" 
        class="p-6 flex flex-col gap-4"
    >
        @csrf
        
        <div class="grow flex items-center">
            <x-text-input id="ticketAmount" name="ticketAmount" type="number" value="" class="grow"/> 
            <p class="mx-2 text-xl">tickets for €</p>
            <output class="text-xl w-20" form="ticketForm" id="priceCalculation" name="priceCalculation" for="ticketAmount">0</output>
        </div>

        <div class="grow">
            <x-input-label for="userEmail" value="Email:" class="text-xl"/>
            <x-text-input 
                id="userEmail" 
                name="userEmail" 
                type="email" 
                value="<?php echo ($user != null) ? $user->email : ''; ?>"
                class="w-full"
            />
        </div>

        <div class="flex justify-end gap-6">
            <x-secondary-button x-data="" x-on:click.prevent="$dispatch('close-modal', 'getTicketModal')">
                Cancel
            </x-secondary-button>        

            <x-primary-button>
                Confirm
            </x-primary-button>        
        </div>

        <input name="eventID" id="eventID" type="hidden" value="{{ $event->id }}">
    </form>
</x-modal>