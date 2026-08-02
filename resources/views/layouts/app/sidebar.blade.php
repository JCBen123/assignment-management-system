<aside id="sidebar" class="bg-gray-400 text-gray-900 border-r border-gray-800 h-[calc(100vh-4rem)] p-4 flex flex-col
    overflow-hidden relative z-50 dark:bg-gray-900 dark:text-white dark:border-gray-700"
>
    <ul class="space-y-3">
        <li>
            <a href="/" class="flex items-center gap-3 px-5 py-4 rounded hover:bg-gray-200 dark:hover:bg-gray-700 relative">
                <flux:icon name="home" />
                <span class="sidebar-text">Home</span>
            </a>
        </li>

        <li>
            <a href="/schedule" class="flex items-center gap-3 px-5 py-4 rounded hover:bg-gray-200 dark:hover:bg-gray-700 relative">
                <flux:icon name="calendar-days" />
                <span class="sidebar-text">Calendar</span>
            </a>
        </li>

        <li>
            <a href="/subjects" class="flex items-center gap-3 px-5 py-4 rounded hover:bg-gray-200 dark:hover:bg-gray-700 relative">
                <flux:icon name="clipboard-document-list" />
                <span class="sidebar-text">Subjects</span>
            </a>
        </li>
    </ul>

    <div class="mt-auto space-y-3 ">
        <div>
            <a href="/profile" class="flex w-full items-center gap-3 px-5 py-4 rounded hover:bg-gray-200 dark:hover:bg-gray-700 relative">
                <flux:icon name="user-circle" />
                <span class="sidebar-text">Profile</span>
            </a>
        </div>
        <div class="border-t border-gray-800/20 pt-3 dark:border-gray-700/50">
            <a href="/settings" class="flex w-full items-center gap-3 px-5 py-4 rounded hover:bg-gray-200 dark:hover:bg-gray-700 relative">
                <flux:icon name="cog-6-tooth" />
                <span class="sidebar-text">Settings</span>
            </a>
        </div>
    </div>
</aside>
