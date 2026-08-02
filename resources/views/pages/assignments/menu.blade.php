@extends('layouts.app.layout')

@section('title', 'Assignments Dashboard')

@section('content')
    <div class="flex flex-col gap-3">
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                    Assignments Dashboard
                </h1>

                <p class="text-gray-700 dark:text-gray-300">
                    Organize your subjects for easier review of assignments
                </p>
            </div>

            <flux:modal.trigger name="new-subject">
                <flux:button variant="primary" class="inline-flex items-center justify-center cursor-pointer rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-blue-700">
                    Add Subject
                </flux:button>
            </flux:modal.trigger>
        </div>

        @if ($subjects->count() > 0)
            <form method="GET" action="{{ route('subjects.menu') }}">
                @csrf

                <div class="rounded-2xl space-y-4 border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                    <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                        <div class="flex-1">
                            <label for="keyword" class="mb-1 block text-sm font-medium">
                                Keyword
                            </label>

                            <input id="keyword" type="text" name="keyword" value="{{ request('keyword') }}" placeholder="Search subjects..."
                                class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm
                                    focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400"
                            >
                        </div>

                        <div class="w-full md:w-48">
                            <label for="sort" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Sort By
                            </label>

                            <select id="sort" name="sort" class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm
                                focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                            >
                                <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name</option>
                                <option value="recent" {{ request('sort') == 'recent' ? 'selected' : '' }}>Recently Added</option>
                            </select>
                        </div>

                        <div class="w-full md:w-40">
                            <label for="direction" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Order
                            </label>

                            <select id="direction" name="direction"
                                class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm
                                    focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                            >
                                <option value="asc" {{ request('direction') == 'asc' ? 'selected' : '' }}>Ascending</option>
                                <option value="desc" {{ request('direction') == 'desc' ? 'selected' : '' }}>Descending</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex w-full gap-2 md:w-auto">
                        <button type="submit"
                            class="inline-flex flex-1 items-center justify-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm
                                transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 md:flex-none cursor-pointer"
                        >
                            Search
                        </button>

                        <a href="{{ route('subjects.menu') }}"
                            class="inline-flex flex-1 items-center justify-center rounded-lg border border-gray-300 bg-gray-100 px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm
                                transition hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-400 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600
                                md:flex-none cursor-pointer"
                        >
                            Reset
                        </a>
                    </div>
                </div>
            </form>
        @endif

        <div class="flex min-h-0 flex-1 flex-col rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <div class="mb-4 flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">View Subjects</h2>

                    <p class="text-sm text-gray-600 dark:text-gray-300">
                        Expand each subject to review its assignments
                    </p>
                </div>
            </div>

            <div class="overflow-y-auto">
                <div class="grid grid-cols-1 gap-4">
                    @forelse ($subjects as $subject)
                        <div class="rounded-xl border border-gray-200 bg-gray-50 p-4 shadow-sm dark:border-gray-700 dark:bg-gray-900/60">
                            <div class="flex items-start justify-between gap-3">
                                <div class="flex items-center gap-2">
                                    <div>
                                        <h3 class="text-base font-semibold text-gray-900 dark:text-white">{{ $subject['name'] }}</h3>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $subject['code'] }}</p>
                                    </div>

                                    <flux:modal.trigger name="edit-subject">
                                        <flux:button variant="ghost" size="sm" class="cursor-pointer"
                                            data-id="{{ $subject->id }}" data-name="{{ $subject->name }}"
                                            data-code="{{ $subject->code }}" data-remarks="{{ $subject->remarks }}"
                                        >
                                            <flux:icon name="pencil-square" />
                                        </flux:button>
                                    </flux:modal.trigger>
                                </div>

                                <div class="flex items-center gap-2">
                                    <div class="flex flex-wrap items-center gap-3">
                                        @php
                                            $statusCounts = collect($subject['assignments'])->groupBy(function ($assignment) {
                                                return strtolower($assignment['status']);
                                            })->map(fn ($group) => $group->count());
                                        @endphp

                                        @foreach (['pending', 'completed', 'overdue'] as $status)
                                            @php
                                                $count = $statusCounts[$status] ?? 0;

                                                $statusClass = match ($status) {
                                                    'completed' => 'bg-green-100 text-green-700 dark:bg-green-900/50 dark:text-green-200',
                                                    'overdue' => 'bg-red-100 text-red-700 dark:bg-red-900/50 dark:text-red-200',
                                                    default => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/50 dark:text-yellow-200',
                                                };

                                                $statusIcon = match ($status) {
                                                    'completed' => 'check-circle',
                                                    'overdue' => 'exclamation-circle',
                                                    default => 'clock',
                                                };
                                            @endphp

                                            <div x-data="{ show: false }" class="relative inline-flex" @mouseenter="show = true" @mouseleave="show = false">
                                                <div class="flex items-center rounded-full border border-gray-200 px-2 py-1.5 text-sm dark:border-gray-700 {{ $statusClass }}">
                                                    <span class="inline-flex h-6 w-10 items-center justify-center rounded-full text-xs font-semibold">
                                                        <flux:icon name="{{ $statusIcon }}" />
                                                    </span>

                                                    <span class="ml-1 text-xs font-medium text-gray-600 dark:text-gray-300">{{ $count }}</span>
                                                </div>

                                                <div x-show="show" x-transition
                                                    class="absolute left-1/2 top-full z-[9999] mt-2 -translate-x-1/2 whitespace-nowrap rounded-md px-2 py-1 text-xs font-medium
                                                        bg-gray-900 text-white shadow-lg dark:bg-gray-700"
                                                >
                                                    {{ ucfirst($status) }}
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('subjects.details', ['subject' => $subject->id]) }}" class="inline-flex items-center rounded-md border border-gray-300 bg-gray-100 px-3 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-200
                                            dark:border-gray-500 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600" wire:navigate>
                                            View Assignments
                                        </a>

                                        <flux:modal.trigger name="delete-subject">
                                            <flux:button type="button" data-id="{{ $subject->id }}"
                                                class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-red-200 bg-white text-red-600 shadow-sm transition
                                                    hover:bg-red-50 dark:border-red-800 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-red-950/40 cursor-pointer"
                                            >
                                                <flux:icon name="trash" />
                                            </flux:button>
                                        </flux:modal.trigger>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="rounded-xl border border-dashed border-gray-300 bg-gray-50 p-8 text-center dark:border-gray-700 dark:bg-gray-900/60">
                            <p class="text-gray-600 dark:text-gray-300">
                                No subjects added
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    @include('modals.new-subject-modal')
    @include('modals.edit-subject-modal')
    @include('modals.delete-subject-modal')

@endsection
