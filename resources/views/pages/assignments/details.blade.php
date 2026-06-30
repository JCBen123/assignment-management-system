@extends('layouts.app.layout')

@section('title', 'Assignments Details')

@section('content')
    @php
        $subject = [
            'code' => 'MTH101',
            'name' => 'Mathematics',
            'description' => 'Core mathematics assignments for the current term.',
        ];

        $assignments = [
            ['title' => 'Algebra Quiz', 'status' => 'Pending', 'due' => 'Jun 30, 2026', 'description' => 'Complete the algebra quiz and submit before the deadline.'],
            ['title' => 'Geometry Worksheet', 'status' => 'Overdue', 'due' => 'Jun 20, 2026', 'description' => 'Review the geometry worksheet and submit your corrections.'],
            ['title' => 'Problem Set Review', 'status' => 'Completed', 'due' => 'Jun 12, 2026', 'description' => 'Review the corrected problem set with feedback from the instructor.'],
        ];

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

    <div x-data="{
        activeTab: '{{ $activeTab }}',
        showViewModal: false,
        selectedAssignment: null,
        sortBy: '{{ $sortBy }}',
        sortDirection: '{{ $sortDirection }}'
    }">
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                    {{ $subject['code'] }}: {{ $subject['name'] }}
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
                                    <div class="flex items-center gap-3">
                                        <div>
                                            <h3 class="text-base font-semibold text-gray-900 dark:text-white">{{ $assignment['title'] }}</h3>
                                            <p class="text-sm text-gray-600 dark:text-gray-300">Due: {{ $assignment['due'] }}</p>
                                        </div>
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
                                            {{ $assignment['status'] }}
                                        </span>

                                        <flux:modal.trigger name="view-assignment">
                                            <flux:button type="button"
                                                class="ml-2 inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium
                                                    text-gray-700 shadow-sm hover:bg-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 cursor-pointer"
                                                @click="selectedAssignment = {
                                                    title: '{{ $assignment['title'] }}',
                                                    due: '{{ $assignment['due'] }}',
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
        @include('modals.assignment-details-modal')

        {{-- <div x-show="showViewModal" x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-4">
            <div class="w-full max-w-lg rounded-2xl bg-white p-6 shadow-xl dark:bg-gray-800">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white" x-text="selectedAssignment?.title || 'Assignment Details'"></h3>
                        <p class="text-sm text-gray-600 dark:text-gray-300" x-text="selectedAssignment?.status || ''"></p>
                    </div>
                    <button type="button" class="rounded-md p-2 text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-300 dark:hover:bg-gray-700" @click="showViewModal = false">
                        ✕
                    </button>
                </div>

                <div class="mt-6 space-y-4 text-sm text-gray-700 dark:text-gray-200">
                    <div>
                        <p class="font-semibold text-gray-900 dark:text-white">Due Date</p>
                        <p x-text="selectedAssignment?.due || ''"></p>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900 dark:text-white">Description</p>
                        <p x-text="selectedAssignment?.description || ''"></p>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
@endsection
