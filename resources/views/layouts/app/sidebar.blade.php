<aside id="sidebar" class="w-64 bg-gray-900 text-white h-screen p-4 flex flex-col transition-all duration-300 ease-in-out overflow-hidden">
    <div class="sidebar-title text-lg font-semibold mb-3 text-center h-24 leading-6 overflow-hidden transition-opacity duration-200">
        <a href="/">
            <img src="{{ asset('storage/logo/ams-dark.png') }}" alt="logo-light" class="h-30 mx-auto my-auto">
        </a>
    </div>

    <ul class="space-y-3">
        <li>
            <a href="/" class="flex items-center gap-3 px-3 py-2 rounded hover:bg-gray-700 relative">
                <flux:icon name="home" />
                <span class="sidebar-text transition-all duration-300">Home</span>
            </a>
        </li>
    </ul>

    <div class="mt-auto">
        <div class="mt-auto w-full flex justify-end">
            <button id="sidebar-open" class="p-2 rounded hover:bg-gray-700/50 hidden">
                <flux:icon  name="chevron-double-right" />
            </button>

            <button id="sidebar-close" class="p-2 rounded hover:bg-gray-700/50">
                <flux:icon name="chevron-double-left" />
            </button>
        </div>
    </div>
</aside>
