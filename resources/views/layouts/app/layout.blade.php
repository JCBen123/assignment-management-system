<!DOCTYPE html>
<html lang="en" class="{{ session('darkMode') ? 'dark' : '' }}">
    <head>
        <meta charset="UTF-8">
        <title>
            @yield('title', 'Assignment Management System')
        </title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://cdn.tailwindcss.com"></script>

        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

        <script>
            tailwind.config = {
                darkMode: 'class'
            }
        </script>

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

        <script>
            document.addEventListener('livewire:init', () => {
                Livewire.on('dark-mode-changed', (event) => {
                    document.documentElement.classList.toggle('dark', event.dark);
                });
            });
        </script>
    </body>

</html>
