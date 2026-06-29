@props([
    'text' => '',
    'position' => 'top',
])

@php
    $positions = [
        'top' => 'bottom-full',
        'bottom' => 'top-full',
        'left' => 'right-full',
        'right' => 'left-full',
    ];
@endphp

<div class="group relative inline-flex">
    {{ $slot }}

    <span class="pointer-events-none absolute z-[9999] whitespace-nowrap rounded-md
                 bg-gray-900 px-2 py-1 text-[11px] font-medium text-white
                 opacity-0 transition-opacity duration-150
                 group-hover:opacity-100 dark:bg-gray-700
                 {{ $positions[$position] ?? $positions['top'] }}">
        {{ $text }}
    </span>
</div>
