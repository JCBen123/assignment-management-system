<nav class="w-full h-16 bg-gray-300 text-gray-900 shadow border-b border-gray-800 flex items-center justify-between px-6
    dark:bg-gray-800 dark:text-white dark:border-gray-700">
    <div class="h-full flex items-center gap-4">
        <flux:icon name="bars-3" class="h-10 w-auto mt-3 mb-3 cursor-pointer transition-none" id="sidebar-toggle" />
        <a href="/" class="h-full flex items-center">
            <img src="{{ asset('storage/logo/ams-light.png') }}" alt="logo-light" class="h-10 w-auto mt-3 mb-3 block dark:hidden">
            <img src="{{ asset('storage/logo/ams-dark.png') }}" alt="logo-dark" class="h-10 w-auto mt-3 mb-3 hidden dark:block">
        </a>
    </div>

    <div class="flex items-center gap-4">
        <!-- Dark Mode button -->
        <flux:button x-data x-on:click="$flux.appearance = $flux.appearance === 'dark' ? 'light' : 'dark'"
            icon="moon" variant="subtle" aria-label="Toggle dark mode"
        />

        <!-- Notifications button -->
        <div x-data="{ open: false }" class="relative">
            <button class="relative p-2 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700 focus:outline-none" title="Notifications" aria-label="Notifications">
                <flux:icon name="bell-alert" class="cursor-pointer transition-none" />
            </button>
        </div>

        <!-- User section -->
        <div x-data="{ open: false }" x-cloak class="relative">
            <button
                type="button"
                @click="open = !open"
                @click.away="open = false"
                @keydown.escape.window="open = false"
                class="flex items-center space-x-2 cursor-pointer font-medium focus:outline-none hover:text-gray-600 dark:hover:text-gray-300"
            >
                <span>{{ auth()->check() ? auth()->user()->name : 'Guest' }}</span>
                <div class="w-8 h-8 rounded-full bg-gray-500 overflow-hidden">
                    <!-- for profile pic -->
                </div>
            </button>

            <div x-show="open" x-transition.opacity style="display: none;"
                class="absolute right-0 mt-2 w-48 overflow-hidden rounded-xl border border-gray-200 bg-white text-sm shadow-lg ring-1 ring-black ring-opacity-5 dark:border-gray-700 dark:bg-gray-800 z-20"
            >
                <div class="flex flex-col py-2">
                    @guest
                        <a href="/login" wire:navigate
                            class="block px-4 py-2 text-left text-sm text-gray-900 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                        >
                            {{ __('Log in') }}
                        </a>
                        <a href="/register" wire:navigate
                            class="block px-4 py-2 text-left text-sm text-gray-900 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                        >
                            {{ __('Register') }}
                        </a>
                    @else
                        <form method="POST" action="/logout" class="w-full">
                            @csrf
                            <button
                                type="submit"
                                class="w-full px-4 py-2 text-left text-sm text-gray-900 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                            >
                                {{ __('Log out') }}
                            </button>
                        </form>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</nav>
