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
    >
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

        <div class="rounded-2xl mt-6 border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
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
                                        <flux:modal.trigger name="edit-assignment">
                                            <flux:button variant="ghost" size="sm" class="cursor-pointer"
                                                data-id="{{ $assignment->id }}" data-title="{{ $assignment->title }}"
                                                data-deadline="{{ $assignment->deadline }}" data-remarks="{{ $assignment->remarks }}"
                                            >
                                                <flux:icon name="pencil-square" />
                                            </flux:button>
                                        </flux:modal.trigger>
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

                                        <flux:modal.trigger name="view-assignment">
                                            <flux:button type="button"
                                                class="ml-2 inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium
                                                    text-gray-700 shadow-sm hover:bg-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 cursor-pointer"
                                                @click="selectedAssignment = {
                                                    id: '{{ $assignment['id'] }}',
                                                    title: '{{ $assignment['title'] }}',
                                                    due: '{{ $assignment['deadline'] }}',
                                                    status: '{{ $assignment['status'] }}',
                                                    description: '{{ addslashes($assignment['description']) }}'
                                                }"
                                            >
                                                View
                                            </flux:button>
                                        </flux:modal.trigger>
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
        @include('modals.assignment-details-modal')
    </div>
@endsection
