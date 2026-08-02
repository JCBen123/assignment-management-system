<div class="flex items-start max-md:flex-col">
    <div class="me-10 w-full pb-4 md:w-[220px] border-r border-gray-800 dark:border-gray-400">
        <ul class="space-y-2">
            <li>
                <a href="/settings" class="flex items-center px-3 py-2 rounded relative
                    hover:bg-gray-200 dark:hover:bg-gray-600" wire:navigate>
                    <div class="flex items-center gap-x-3">
                        <flux:icon name="cog-6-tooth" />
                        <span>General</span>
                    </div>
                </a>
            </li>

            @auth
                <li>
                    <a href="/personal-info" class="flex items-center px-3 py-2 rounded relative
                        hover:bg-gray-200 dark:hover:bg-gray-600" wire:navigate>
                        <div class="flex items-center gap-x-3">
                            <flux:icon name="user" />
                            <span>Personal Info</span>
                        </div>
                    </a>
                </li>

                <li>
                    <a href="/security" class="flex items-center gap-3 px-3 py-2 rounded relative
                        hover:bg-gray-200 dark:hover:bg-gray-600" wire:navigate>
                        <flux:icon name="lock-closed" />
                        <span>Security</span>
                    </a>
                </li>
            @endauth
        </ul>
    </div>

    <flux:separator class="md:hidden" />

    <div class="flex-1 self-stretch max-md:pt-6">
        <flux:heading>{{ $heading ?? '' }}</flux:heading>
        <flux:subheading>{{ $subheading ?? '' }}</flux:subheading>

        <div class="mt-5 w-full max-w-lg">
            {{ $slot }}
        </div>
    </div>
</div>
