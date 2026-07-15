<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>
            @yield('title', 'Assignment Management System')
        </title>

        <link rel="icon" href="{{ asset('storage/logo/ams-light.png') }}" media="(prefers-color-scheme: light)">
        <link rel="icon" href="{{ asset('storage/logo/ams-dark.png') }}" media="(prefers-color-scheme: dark)">
        <link rel="apple-touch-icon" href="{{ asset('storage/logo/ams-light.png') }}">

        @fluxAppearance

        <script>
            window.addEventListener('DOMContentLoaded', () => {
                if (!localStorage.getItem('flux.appearance')) {
                    localStorage.setItem(
                        'flux.appearance',
                        document.documentElement.classList.contains('dark')
                            ? 'dark'
                            : 'light'
                    )
                }
            })
        </script>

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @livewireStyles
    </head>

    <body class="bg-gray-100 dark:bg-gray-700 dark:text-white h-screen overflow-none">
        @include('layouts.app.navbar')

        <div class="flex h-[calc(100vh-4rem)]">
            @include('layouts.app.sidebar')
            <main class="flex-1 min-h-0 overflow-y-auto p-6">
                @yield('content')
            </main>
        </div>

        @stack('scripts')

        @livewireScripts
        @fluxScripts
    </body>

</html>
