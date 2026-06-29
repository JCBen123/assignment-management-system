@extends('layouts.app.layout')

@section('title', 'Assignments Dashboard')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                    Assignments Dashboard
                </h1>
                <p class="text-gray-700 dark:text-gray-300">
                    Organize your subjects for easier review of assignments
                </p>
            </div>

            <button id="new-subject" type="button" class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-blue-700">
                Add New Subject
            </button>
        </div>

        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <div class="mb-4 flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">View Subjects</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-300">
                        Expand each subject to review its assignments
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-4">
                @php
                    $subjects = [
                        [
                            'name' => 'Mathematics',
                            'code' => 'MTH101',
                            'assignments' => [
                                ['title' => 'Algebra Quiz', 'due' => 'Jun 30, 2026', 'status' => 'Pending'],
                                ['title' => 'Geometry Worksheet', 'due' => 'Jul 05, 2026', 'status' => 'In Review'],
                            ],
                        ],
                        [
                            'name' => 'Science',
                            'code' => 'SCI202',
                            'assignments' => [
                                ['title' => 'Lab Report', 'due' => 'Jul 08, 2026', 'status' => 'Pending'],
                                ['title' => 'Research Summary', 'due' => 'Jul 11, 2026', 'status' => 'Completed'],
                            ],
                        ],
                        [
                            'name' => 'English',
                            'code' => 'ENG201',
                            'assignments' => [
                                ['title' => 'Literature Review', 'due' => 'Jul 18, 2026', 'status' => 'Pending'],
                            ],
                        ],
                    ];
                @endphp

                @foreach ($subjects as $subject)
                    <div class="rounded-xl border border-gray-200 bg-gray-50 p-4 shadow-sm dark:border-gray-700 dark:bg-gray-900/60">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <h3 class="text-base font-semibold text-gray-900 dark:text-white">{{ $subject['name'] }}</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $subject['code'] }}</p>
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

                                        <x-tooltip text="{{ ucfirst($status) }}" position="bottom">
                                            <div class="flex items-center rounded-full border border-gray-200 px-2 py-1.5 text-sm dark:border-gray-700 {{ $statusClass }}">
                                                <span class="inline-flex h-6 w-10 items-center justify-center rounded-full text-xs font-semibold">
                                                    <flux:icon name="{{ $statusIcon }}" />
                                                </span>
                                                <span class="ml-1 text-xs font-medium text-gray-600 dark:text-gray-300">{{ $count }}</span>
                                            </div>
                                        </x-tooltip>

                                    @endforeach
                                </div>

                                <a href="/assignments/details" class="inline-flex items-center rounded-md border border-gray-300 bg-gray-100 px-3 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-100
                                    dark:border-gray-500 dark:bg-gray-700 dark:text-gray-200">
                                    View Assignments
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @include('modals.new-subject-modal')

@endsection
