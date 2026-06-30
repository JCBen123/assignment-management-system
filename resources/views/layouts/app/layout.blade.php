<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>
            @yield('title', 'Assignment Management System')
        </title>

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

    <body class="bg-gray-100 dark:bg-gray-700 dark:text-white">
        @include('layouts.app.navbar')

        <div class="flex">
            @include('layouts.app.sidebar')
            <main class="flex-1 p-6">
                @yield('content')
            </main>
        </div>

        @stack('scripts')

        @livewireScripts
        @fluxScripts
    </body>

</html>
