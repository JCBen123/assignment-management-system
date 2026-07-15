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
            <button @click="open = !open" @click.away="open = false" class="relative p-2 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700 focus:outline-none" title="Notifications" aria-label="Notifications">
                <flux:icon name="bell-alert" class="cursor-pointer transition-none" />
                @auth
                    @if (auth()->user()->unreadNotificationsCount() > 0)
                        <span class="absolute -top-1 -right-1 inline-flex items-center justify-center rounded-full bg-red-600 px-1.5 py-0.5 text-[10px] font-semibold text-white">
                            {{ auth()->user()->unreadNotificationsCount() }}
                        </span>
                    @endif
                @endauth
            </button>

            @auth
                <div x-show="open" x-transition.opacity style="display: none;" class="absolute right-0 mt-2 w-80 overflow-hidden rounded-xl border border-gray-200 bg-white text-sm shadow-lg ring-1 ring-black ring-opacity-5 dark:border-gray-700 dark:bg-gray-800 z-20">
                    <div class="flex items-center justify-between border-b border-gray-200 px-4 py-3 dark:border-gray-700">
                        <div class="font-semibold text-gray-900 dark:text-white">Notifications</div>
                        @if (auth()->user()->unreadNotificationsCount() > 0)
                            <form method="POST" action="{{ route('notifications.mark-all-as-read') }}">
                                @csrf
                                <button type="submit" class="text-sm font-medium text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 cursor-pointer">
                                    Mark all as read
                                </button>
                            </form>
                        @endif
                    </div>
                    <div class="max-h-72 overflow-y-auto">
                        @forelse (auth()->user()->notifications()->latest()->take(8)->get() as $notification)
                            <div class="flex items-start justify-between gap-2 border-b border-gray-100 px-4 py-3 text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-200 dark:hover:bg-gray-700">
                                <a href="{{ route('subjects.menu') }}" class="flex-1">
                                    <div class="font-medium">{{ $notification->data['subject'] ?? 'Assignment update' }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ $notification->data['message'] ?? '' }}</div>
                                    <div class="mt-1 text-[11px] text-gray-400 dark:text-gray-500">
                                        {{ $notification->created_at->diffForHumans() }}
                                    </div>
                                </a>

                                @if ($notification->read_at == null)
                                    <form method="POST" action="{{ route('notifications.mark-as-read', $notification) }}">
                                        @csrf
                                        <button type="submit" class="rounded p-1 text-green-600 transition hover:bg-green-100 hover:text-green-700 dark:hover:bg-green-900/30 cursor-pointer">
                                            <flux:icon name="check" class="h-4 w-4" />
                                        </button>
                                    </form>
                                @endif
                            </div>
                        @empty
                            <div class="px-4 py-6 text-center text-sm text-gray-500 dark:text-gray-400">
                                No notifications yet.
                            </div>
                        @endforelse
                    </div>
                </div>
            @endauth
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
                @php
                    $profileImage = auth()->user()->profile_image;
                @endphp

                <span>{{ auth()->check() ? auth()->user()->name : 'Guest' }}</span>
                <div class="w-8 h-8 rounded-full bg-gray-500 overflow-hidden">
                    @if ($profileImage)
                        <img src="{{ asset('storage/'.$profileImage->path) }}" alt="Profile picture" class="h-8 w-8 rounded-full object-cover ring-2 ring-sky-200 dark:ring-sky-900">
                    @else
                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-sky-100 text-2xl font-bold text-sky-700 dark:bg-sky-900/40 dark:text-sky-200">
                            {{ auth()->user()->initials() }}
                        </div>
                    @endif
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
