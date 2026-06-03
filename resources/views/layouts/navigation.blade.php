<nav x-data="{ open: false }" class="bg-white border-b border-gray-200 shadow-sm">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Navigation Links -->
                <div class="flex items-center space-x-8">
                    <x-nav-link :href="route('tasks.index')" class="!text-3xl font-semibold">
                        {{ __('common.task_manager') }}
                    </x-nav-link>
                    <x-nav-link :href="route('task_statuses.index')" :active="request()->routeIs('task_statuses.index')" class="text-xl">
                        {{ __('common.statuses') }}
                    </x-nav-link>
                    <x-nav-link :href="route('tasks.index')" :active="request()->routeIs('tasks.index')" class="text-xl">
                        {{ __('common.tasks') }}
                    </x-nav-link>
                    <x-nav-link :href="route('labels.index')" :active="request()->routeIs('labels.index')" class="text-xl">
                        {{ __('common.labels') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Language Switcher -->
            <div class="flex items-center space-x-2">
                @php
                    $currentLocale = app()->getLocale();
                @endphp

                <a href="{{ route('language.switch', 'en') }}"
                   class="px-3 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out
                          {{ $currentLocale == 'en'
                              ? 'bg-blue-600 text-white'
                              : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                    EN
                </a>
                <a href="{{ route('language.switch', 'ru') }}"
                   class="px-3 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out
                          {{ $currentLocale == 'ru'
                              ? 'bg-blue-600 text-white'
                              : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                    RU
                </a>
            </div>

            <!-- Logout Button -->
            @auth
                <div class="flex items-center ml-6">
                    <a href="{{ route('logout') }}" class="text-xl text-gray-600 hover:text-gray-900 transition">
                        {{ __('common.log_out') }}
                    </a>
                </div>
            @else
                <div class="flex items-center ml-6">
                    <div class="space-x-4">
                        <a href="{{ route('login') }}" class="text-xl text-gray-600 hover:text-gray-900 transition">
                            {{ __('common.login') }}
                        </a>
                        <a href="{{ route('register') }}" class="text-xl text-gray-600 hover:text-gray-900 transition">
                            {{ __('common.register') }}
                        </a>
                    </div>
                </div>
            @endauth

        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        @auth
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('task_statuses.index')" :active="request()->routeIs('task_statuses.*')" class="text-xl">
                    {{ __('common.statuses') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('tasks.index')" :active="request()->routeIs('tasks.*')" class="text-xl">
                    {{ __('common.tasks') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('labels.index')" :active="request()->routeIs('labels.*')" class="text-xl">
                    {{ __('common.labels') }}
                </x-responsive-nav-link>
            </div>

            <!-- Responsive Settings Options -->
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="px-4">
                    <div class="font-medium text-xl text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-lg text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <!-- Language Switcher in mobile menu -->
                    <div class="flex items-center space-x-2 px-4 py-2">
                        <a href="{{ route('language.switch', 'en') }}"
                           class="px-3 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out
                                  {{ app()->getLocale() == 'en'
                                      ? 'bg-blue-600 text-white'
                                      : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                            EN
                        </a>
                        <a href="{{ route('language.switch', 'ru') }}"
                           class="px-3 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out
                                  {{ app()->getLocale() == 'ru'
                                      ? 'bg-blue-600 text-white'
                                      : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                            RU
                        </a>
                    </div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                                               onclick="event.preventDefault(); this.closest('form').submit();"
                                               class="text-lg">
                            {{ __('common.log_out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @else
            <div class="pt-2 pb-3 space-y-1">
                <div class="px-4">
                    <div class="font-medium text-xl text-gray-800">{{ __('common.guest') }}</div>
                    <div class="mt-3 space-y-1">
                        <!-- Language Switcher for guests -->
                        <div class="flex items-center space-x-2 px-4 py-2">
                            <a href="{{ route('language.switch', 'en') }}"
                               class="px-3 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out
                                      {{ app()->getLocale() == 'en'
                                          ? 'bg-blue-600 text-white'
                                          : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                                EN
                            </a>
                            <a href="{{ route('language.switch', 'ru') }}"
                               class="px-3 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out
                                      {{ app()->getLocale() == 'ru'
                                          ? 'bg-blue-600 text-white'
                                          : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                                RU
                            </a>
                        </div>

                        <a href="{{ route('login') }}" class="block w-full px-4 py-2 text-left text-xl leading-5 text-gray-700 hover:bg-gray-100 transition rounded-md">
                            {{ __('common.login') }}
                        </a>
                        <a href="{{ route('register') }}" class="block w-full px-4 py-2 text-left text-xl leading-5 text-gray-700 hover:bg-gray-100 transition rounded-md">
                            {{ __('common.register') }}
                        </a>
                    </div>
                </div>
            </div>
        @endauth
    </div>
</nav>
