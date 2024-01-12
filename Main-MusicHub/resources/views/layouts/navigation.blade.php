<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="mx-12 px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">

                    <!-- Home page -->
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                        {{ __('Home') }}
                    </x-nav-link>

                    <!-- Instruments page -->
                    <x-nav-link :href="route('instruments.index')" :active="request()->routeIs('instruments.index')">
                        {{ __('Instruments') }}
                    </x-nav-link>

                    <!-- Events page -->
                    <x-nav-link :href="route('events.index')" :active="request()->routeIs('events.index')">
                        {{ __('Events') }}
                    </x-nav-link>

                    <!-- Sheet music page -->
                    <x-nav-link :href="route('sheetmusic.index')" :active="request()->routeIs('sheetmusic.index')">
                        {{ __('Sheet Music') }}
                    </x-nav-link>

                    <!-- Message page -->
                    <x-nav-link :href="route('messages.index')" :active="request()->routeIs('messages.index')">
                        {{ __('Messages') }}
                    </x-nav-link>

                    <!-- Music Session page -->
                    <x-nav-link :href="route('musicSession.show')" :active="request()->routeIs('musicSession.show')">
                        {{ __('Music Session') }}
                    </x-nav-link>

                    <!-- Tuner page -->
                    <x-nav-link :href="route('tuner.show')" :active="request()->routeIs('tuner.show')">
                        {{ __('Tuner') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            @auth
                            <div>{{ Auth::user()->name }}</div>
                            @else
                            <div>{{ "Not logged in" }}</div>
                            @endauth
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>


                    <x-slot name="content">
                        @auth
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ 'Profile' }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ 'Log Out' }}
                            </x-dropdown-link>
                        </form>
                        @else
                        <x-dropdown-link :href="route('login')">
                            {{ 'Log in' }}
                        </x-dropdown-link>
                        @endauth
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </div>
</nav>
