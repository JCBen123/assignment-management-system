@extends('layouts.app.layout')

@section('title', 'Assignments Details')

@section('content')
    @php
        $activeTab = request()->query('active_tab', 'all');
        $sortBy = request()->query('sort_by', 'deadline');
        $sortDirection = request()->query('sort_dir', 'asc');

        $sortBy = in_array($sortBy, ['deadline', 'name'], true) ? $sortBy : 'deadline';
        $sortDirection = in_array($sortDirection, ['asc', 'desc'], true) ? $sortDirection : 'asc';

        $assignments = collect($assignments)
            ->sortBy(function ($assignment) use ($sortBy) {
                return $sortBy === 'name' ? strtolower($assignment['title']) : strtotime($assignment['due']);
            }, SORT_NATURAL, $sortDirection === 'desc')
            ->values()
            ->all();

        $tabs = [
            ['key' => 'all', 'label' => 'All'],
            ['key' => 'pending', 'label' => 'Pending'],
            ['key' => 'completed', 'label' => 'Completed'],
            ['key' => 'overdue', 'label' => 'Overdue'],
        ];
    @endphp

    <div x-data="{activeTab: '{{ $activeTab }}', showViewModal: false, selectedAssignment: null,
        sortBy: '{{ $sortBy }}', sortDirection: '{{ $sortDirection }}'}"
        class="flex flex-col gap-3"
    >
        <div>
            <div class="flex mb-2">
                <a href="{{ url()->previous() !== url()->current() ? url()->previous() : route('subjects.menu') }}"
                    class="flex gap-2 cursor-pointer" wire:navigate
                >
                    <flux:icon name="arrow-left-circle"></flux:icon>
                    Back
                </a>
            </div>
            <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                        {{ $subject['code'] }} - {{ $subject['name'] }}
                    </h1>
                    <p class="text-gray-700 dark:text-gray-300">
                        {{ $subject['description'] }}
                    </p>
                </div>

                <flux:modal.trigger name="new-assignment">
                    <flux:button variant="primary" class="inline-flex items-center justify-center cursor-pointer rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-blue-700">
                        Add Assignment
                    </flux:button>
                </flux:modal.trigger>
            </div>
        </div>

        @if (!empty($assignments) > 0)
            <form method="GET" action="{{ route('subjects.details', ['subject' => $subject->id]) }}">
                @csrf
                <div class="rounded-2xl space-y-4 border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                    <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                        <div class="flex-1">
                            <label for="keyword" class="mb-1 block text-sm font-medium">
                                Keyword
                            </label>

                            <input
                                id="keyword"
                                type="text"
                                name="keyword"
                                value="{{ request('keyword') }}"
                                placeholder="Search assignments..."
                                class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm
                                    focus:border-blue-500 focus:ring-blue-500
                                    dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400"
                            >
                        </div>

                        <div class="w-full md:w-48">
                            <label for="sort" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Sort By
                            </label>

                            <select
                                id="sort"
                                name="sort"
                                class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm
                                    focus:border-blue-500 focus:ring-blue-500
                                    dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                            >
                                <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name</option>
                                <option value="deadline" {{ request('sort') == 'deadline' ? 'selected' : '' }}>Deadline</option>
                                <option value="recent" {{ request('sort') == 'recent' ? 'selected' : '' }}>Recently Added</option>
                            </select>
                        </div>

                        <div class="w-full md:w-40">
                            <label for="direction" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Order
                            </label>

                            <select
                                id="direction"
                                name="direction"
                                class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm
                                    focus:border-blue-500 focus:ring-blue-500
                                    dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                            >
                                <option value="asc" {{ request('direction') == 'asc' ? 'selected' : '' }}>Ascending</option>
                                <option value="desc" {{ request('direction') == 'desc' ? 'selected' : '' }}>Descending</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex w-full gap-2 md:w-auto">
                        <button
                            type="submit"
                            class="inline-flex flex-1 items-center justify-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm
                                transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500
                                md:flex-none cursor-pointer"
                        >
                            Search
                        </button>

                        <a href="{{ route('subjects.details', ['subject' => $subject->id]) }}"
                            class="inline-flex flex-1 items-center justify-center rounded-lg border border-gray-300 bg-gray-100 px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm
                                transition hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-400
                                dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600
                                md:flex-none cursor-pointer"
                        >
                            Reset
                    </a>
                    </div>
                </div>
            </form>
        @endif

        <div class="flex flex-1 flex-col rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <div class="flex flex-wrap items-center justify-between gap-3 border-b border-gray-200 pb-4 dark:border-gray-700">
                <div class="flex flex-wrap gap-2">
                    @foreach ($tabs as $tab)
                        <button
                            type="button"
                            class="rounded-full px-4 py-2 text-sm font-medium transition"
                            :class="activeTab === '{{ $tab['key'] }}' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600'"
                            @click="activeTab = '{{ $tab['key'] }}'"
                        >
                            {{ $tab['label'] }}
                        </button>
                    @endforeach
                </div>
            </div>

            <div class="mt-6 space-y-3">
                @foreach ($tabs as $tab)
                    <div x-show="activeTab === '{{ $tab['key'] }}'" class="space-y-3">
                        @php
                            $filteredAssignments = collect($assignments)->filter(function ($assignment) use ($tab) {
                                if ($tab['key'] === 'all') {
                                    return true;
                                }

                                return strtolower($assignment['status']) === $tab['key'];
                            })->values();
                        @endphp

                        @if ($filteredAssignments->isEmpty())
                            <div class="rounded-xl border border-dashed border-gray-300 bg-gray-50 px-4 py-6 text-center text-sm text-gray-500 dark:border-gray-600 dark:bg-gray-900/50 dark:text-gray-400">
                                No {{ strtolower($tab['label']) }} assignments yet.
                            </div>
                        @else
                            @foreach ($filteredAssignments as $assignment)
                                <div class="flex flex-col gap-3 rounded-xl border border-gray-200 bg-gray-50 p-4 shadow-sm sm:flex-row sm:items-center sm:justify-between dark:border-gray-700 dark:bg-gray-900/60">
                                    <div class="flex items-center gap-2">
                                        <div>
                                            <h3 class="text-base font-semibold text-gray-900 dark:text-white">{{ $assignment['title'] }}</h3>
                                            <p class="text-sm text-gray-600 dark:text-gray-300">
                                                Due: {{ \Carbon\Carbon::parse($assignment->deadline)->format('d M Y') }}
                                                @if ($assignment->status != 'completed')
                                                    @php
                                                        $today = \Carbon\Carbon::today();
                                                        $deadline = \Carbon\Carbon::parse($assignment->deadline)->startOfDay();
                                                        $days = $today->diffInDays($deadline, false);
                                                    @endphp

                                                    @if ($days == 1)
                                                        (Tomorrow)
                                                    @elseif ($days == -1)
                                                        (Yesterday)
                                                    @elseif ($days > 1)
                                                        ({{ $days }} days left)
                                                    @elseif ($days < -1)
                                                        ({{ abs($days) }} days overdue)
                                                    @else
                                                        (Due today)
                                                    @endif
                                                @else
                                                    (Completed on {{ \Carbon\Carbon::parse($assignment->completion_date)->format('d M Y') }})
                                                @endif
                                            </p>
                                        </div>
                                        @if ($assignment->status != 'completed')
                                            <flux:modal.trigger name="edit-assignment">
                                                <flux:button variant="ghost" size="sm" class="cursor-pointer"
                                                    data-id="{{ $assignment->id }}" data-title="{{ $assignment->title }}"
                                                    data-deadline="{{ $assignment->deadline }}" data-remarks="{{ $assignment->remarks }}"
                                                >
                                                    <flux:icon name="pencil-square" />
                                                </flux:button>
                                            </flux:modal.trigger>
                                        @endif
                                    </div>

                                    <div>
                                        @php
                                            $statusClass = match (strtolower($assignment['status'])) {
                                                'completed' => 'bg-green-100 text-green-700 dark:bg-green-900/50 dark:text-green-200',
                                                'overdue' => 'bg-red-100 text-red-700 dark:bg-red-900/50 dark:text-red-200',
                                                default => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/50 dark:text-yellow-200',
                                            };
                                        @endphp

                                        <span class="inline-flex items-center rounded-full border border-gray-200 px-3 py-1 text-xs font-semibold {{ $statusClass }} dark:border-gray-700 dark:bg-gray-800">
                                            {{ ucfirst($assignment['status']) }}
                                        </span>

                                        <div class="ml-2 inline-flex items-center gap-2">
                                            <flux:modal.trigger name="view-assignment">
                                                <flux:button type="button"
                                                    class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium
                                                        text-gray-700 shadow-sm hover:bg-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 cursor-pointer"
                                                    @click="selectedAssignment = {
                                                        id: '{{ $assignment['id'] }}',
                                                        title: '{{ $assignment['title'] }}',
                                                        deadline: '{{ $assignment['deadline'] }}',
                                                        status: '{{ $assignment['status'] }}',
                                                        remarks: '{{ addslashes($assignment['remarks']) }}'
                                                    }"
                                                >
                                                    View
                                                </flux:button>
                                            </flux:modal.trigger>

                                            <flux:modal.trigger name="delete-assignment">
                                                <flux:button type="button"
                                                        class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-red-500 bg-white text-red-500 shadow-sm transition
                                                            hover:border-red-600 hover:bg-red-50 hover:text-red-600
                                                            dark:bg-gray-800 dark:border-red-700 dark:text-red-400
                                                            dark:hover:border-red-600 dark:hover:bg-red-950/40 dark:hover:text-red-300
                                                            cursor-pointer"
                                                        data-id="{{ $assignment->id }}"
                                                    >
                                                        <flux:icon name="trash" />
                                                    </flux:button>
                                            </flux:modal.trigger>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        @include('modals.new-assignment-modal')
        @include('modals.edit-assignment-modal')
        @include('modals.delete-assignment-modal')
        @include('modals.assignment-details-modal')
    </div>
@endsection
