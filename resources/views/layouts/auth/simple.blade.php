<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white antialiased dark:bg-linear-to-b dark:bg-gray-800 dark:to-neutral-900">
        <nav>
            <flux:button x-data x-on:click="$flux.appearance = $flux.appearance === 'dark' ? 'light' : 'dark'"
                icon="moon" variant="subtle" aria-label="Toggle dark mode"
            />
        </nav>
        <div class="bg-background flex min-h-svh flex-col items-center gap-6 pl-6 pr-6">
            <div class="flex w-full max-w-sm flex-col gap-2">
                <a href="/" class="flex flex-col items-center gap-2 font-medium" wire:navigate>
                    <img src="{{ asset('storage/logo/ams-light.png') }}" alt="logo-light" class="h-10 w-auto mt-3 mb-3 block dark:hidden">
                    <img src="{{ asset('storage/logo/ams-dark.png') }}" alt="logo-dark" class="h-10 w-auto mt-3 mb-3 hidden dark:block">
                </a>
                <div class="flex flex-col gap-6">
                    {{ $slot }}
                </div>
            </div>
        </div>

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts
    </body>
</html>
