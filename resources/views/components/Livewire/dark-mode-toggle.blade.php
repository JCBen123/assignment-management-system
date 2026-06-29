<div class="relative">
    <button wire:click="toggle" class="p-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 cursor-pointer"
        title="{{ $darkMode ? 'Toggle light mode' : 'Toggle dark mode' }}" >
        <flux:icon :name="$darkMode ? 'sun' : 'moon'" class="size-5 transition-transform duration-300 transform" />
    </button>
</div>
