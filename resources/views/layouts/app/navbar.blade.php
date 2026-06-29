<nav class="w-full h-16 bg-gray-300 text-gray-900 shadow border-b border-gray-800 flex items-center justify-between px-6
    dark:bg-gray-800 dark:text-white dark:border-gray-700">
    <div class="h-full flex items-center gap-4">
        <flux:icon name="bars-3" class="h-10 w-auto mt-3 mb-3 cursor-pointer" id="sidebar-toggle" />
        <a href="/" class="h-full flex items-center">
            <img src="{{ asset('storage/logo/ams-light.png') }}" alt="logo-light" class="h-10 w-auto mt-3 mb-3 block dark:hidden">
            <img src="{{ asset('storage/logo/ams-dark.png') }}" alt="logo-dark" class="h-10 w-auto mt-3 mb-3 hidden dark:block">
        </a>
    </div>

    <div class="flex items-center gap-4">
        <livewire:dark-mode-toggle />

        <!-- Notifications button -->
        <div x-data="{ open: false }" class="relative">
            <button class="relative p-2 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700 focus:outline-none" title="Notifications" aria-label="Notifications">
                <flux:icon name="bell-alert" class="cursor-pointer" />
            </button>
        </div>

        <!-- User section -->
        <div x-data="{ open: false }" class="relative">
            <button class="flex items-center space-x-2 cursor-pointer font-medium focus:outline-none hover:text-gray-600 dark:hover:text-gray-300">
                <span>Guest</span>
                <div class="w-8 h-8 rounded-full bg-gray-500 overflow-hidden">
                    <!-- for profile pic -->
                </div>
            </button>
        </div>
    </div>
</nav>
