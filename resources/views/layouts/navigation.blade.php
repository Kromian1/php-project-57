<nav x-data="{ open: false }" class="bg-white border-b border-gray-200 shadow-sm">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Navigation Links -->
                <div class="flex items-center space-x-8">
                    <x-nav-link :href="route('tasks.index')" class="!text-3xl font-semibold">
                        {{ __('Task Manager') }}
                    </x-nav-link>
                    <x-nav-link :href="route('task_statuses.index')" :active="request()->routeIs('task_statuses.index')" class="text-xl">
                        {{ __('Statuses') }}
                    </x-nav-link>
                    <x-nav-link :href="route('tasks.index')" :active="request()->routeIs('tasks.index')" class="text-xl">
                        {{ __('Tasks') }}
                    </x-nav-link>
                    <x-nav-link :href="route('labels.index')" :active="request()->routeIs('labels.index')" class="text-xl">
                        {{ __('Labels') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Logout Button -->
            @auth
                <div class="flex items-center ml-6">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="inline-flex items-center px-3 py-2 border border-transparent text-xl leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 hover:bg-gray-50 focus:outline-none transition ease-in-out duration-150">
                            {{ __('Log Out') }}
                        </button>
                    </form>
                </div>
            @else
                <div class="flex items-center ml-6">
                    <div class="space-x-4">
                        <a href="{{ route('login') }}" class="text-xl text-gray-600 hover:text-gray-900 transition">
                            {{ __('Login') }}
                        </a>
                        <a href="{{ route('register') }}" class="text-xl text-gray-600 hover:text-gray-900 transition">
                            {{ __('Register') }}
                        </a>
                    </div>
                </div>
            @endauth

            <!-- Hamburger -->
            <div class="flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        @auth
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('task_statuses.index')" :active="request()->routeIs('task_statuses.*')" class="text-xl">
                    {{ __('Statuses') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('tasks.index')" :active="request()->routeIs('tasks.*')" class="text-xl">
                    {{ __('Tasks') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('labels.index')" :active="request()->routeIs('labels.*')" class="text-xl">
                    {{ __('Labels') }}
                </x-responsive-nav-link>
            </div>

            <!-- Responsive Settings Options -->
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="px-4">
                    <div class="font-medium text-xl text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-lg text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                                               onclick="event.preventDefault(); this.closest('form').submit();"
                                               class="text-lg">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @else
            <div class="pt-2 pb-3 space-y-1">
                <div class="px-4">
                    <div class="font-medium text-xl text-gray-800">{{ __('Guest') }}</div>
                    <div class="mt-3 space-y-1">
                        <a href="{{ route('login') }}" class="block w-full px-4 py-2 text-left text-xl leading-5 text-gray-700 hover:bg-gray-100 transition rounded-md">
                            {{ __('Login') }}
                        </a>
                        <a href="{{ route('register') }}" class="block w-full px-4 py-2 text-left text-xl leading-5 text-gray-700 hover:bg-gray-100 transition rounded-md">
                            {{ __('Register') }}
                        </a>
                    </div>
                </div>
            </div>
        @endauth
    </div>
</nav>
