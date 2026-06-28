<nav class="fixed top-0 right-0 p-4 flex items-center gap-4 bg-gray-800 text-white z-50 rounded-bl-2xl">
    <livewire:dark-mode-toggle />

    <!-- Notifications button -->
    <div x-data="{ open: false }" class="relative">
        <button class="relative p-2 rounded-full hover:bg-gray-700 focus:outline-none" title="Notifications" aria-label="Notifications" >
            <flux:icon name="bell-alert" />
        </button>
    </div>

    <!-- User section -->
    <div x-data="{ open: false }" class="relative">
        <button class="flex items-center space-x-2 hover:text-gray-300 font-medium focus:outline-none">
            <span>Guest</span>
            <div class="w-8 h-8 rounded-full bg-gray-500 overflow-hidden">
                <!-- for profile pic -->
            </div>
        </button>
    </div>
</nav>
