@extends('layouts.app.layout')

@section('title', 'Home')

@section('content')
    @if (! auth()->check())
        <div class="grid min-h-[calc(100vh-10rem)] items-center gap-8 lg:grid-cols-[1.2fr_0.8fr]">
            <div class="rounded-3xl border border-white/60 bg-gradient-to-br from-blue-600 via-indigo-600 to-violet-700 p-8 text-white shadow-2xl shadow-blue-950/20 dark:border-gray-700">
                <span class="inline-flex items-center rounded-full bg-white/15 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-blue-50">
                    Assignment management at a glance
                </span>
                <h1 class="mt-5 text-4xl font-bold leading-tight sm:text-5xl">
                    Stay on top of every deadline, subject and submission.
                </h1>
                <p class="mt-4 max-w-2xl text-base text-blue-50 sm:text-lg">
                    Keep your workload organized with a clear view of your pending, completed and overdue assignments.
                </p>

                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="/login" class="rounded-full bg-white px-5 py-3 text-sm font-semibold text-blue-700 shadow-lg shadow-blue-950/20 transition hover:bg-blue-50">
                        Sign in
                    </a>
                    <a href="/register" class="rounded-full border border-white/30 bg-white/10 px-5 py-3 text-sm font-semibold text-white transition hover:bg-white/20">
                        Create account
                    </a>
                </div>
            </div>

            <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-xl shadow-slate-200/50 dark:border-gray-700 dark:bg-gray-800 dark:shadow-none">
                <div class="grid gap-4">
                    <div class="rounded-2xl bg-slate-50 p-4 dark:bg-gray-900/60">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-slate-500 dark:text-slate-400">Pending</p>
                                <p class="text-2xl font-bold text-amber-500">Track</p>
                            </div>
                            <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700 dark:bg-amber-900/60 dark:text-amber-200">Live status</span>
                        </div>
                    </div>

                    <div class="rounded-2xl bg-slate-50 p-4 dark:bg-gray-900/60">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-slate-500 dark:text-slate-400">Completed</p>
                                <p class="text-2xl font-bold text-emerald-500">View</p>
                            </div>
                            <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700 dark:bg-emerald-900/60 dark:text-emerald-200">At a glance</span>
                        </div>
                    </div>

                    <div class="rounded-2xl bg-slate-50 p-4 dark:bg-gray-900/60">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-slate-500 dark:text-slate-400">Overdue</p>
                                <p class="text-2xl font-bold text-rose-500">Resolve</p>
                            </div>
                            <span class="rounded-full bg-rose-100 px-3 py-1 text-xs font-semibold text-rose-700 dark:bg-rose-900/60 dark:text-rose-200">Before it escalates</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="space-y-6">
            <div class="flex flex-col gap-4 rounded-3xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800 md:flex-row md:items-center md:justify-between">
                <div>
                    <span class="inline-flex items-center rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700 dark:bg-blue-900/60 dark:text-blue-100">
                        Welcome back
                    </span>
                    <h1 class="mt-3 text-3xl font-bold text-gray-900 dark:text-white">
                        {{ $user->name }}
                    </h1>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
                        Your assignments are summarized below so you can stay ahead of deadlines.
                    </p>
                </div>

                <a href="{{ route('subjects.menu') }}" class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
                    Open assignment menu
                </a>
            </div>

            <div class="grid gap-6 xl:grid-cols-[1.2fr_0.8fr]">
                <div class="space-y-6">
                    <div class="rounded-3xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                        <div class="mb-4 flex items-center justify-between">
                            <div>
                                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Most urgent pending</h2>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Top 3 assignments that need your attention next.</p>
                            </div>
                            <a href="{{ route('subjects.menu') }}" class="rounded-lg border border-gray-200 px-3 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-700">
                                View all
                            </a>
                        </div>

                        @if ($urgentPendingAssignments->isNotEmpty())
                            <div class="space-y-3">
                                @foreach ($urgentPendingAssignments as $assignment)
                                    <div class="rounded-2xl border border-amber-100 bg-amber-50 p-4 dark:border-amber-900/60 dark:bg-amber-950/30">
                                        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                                            <div>
                                                <p class="font-semibold text-gray-900 dark:text-white">{{ $assignment->title }}</p>
                                                <p class="text-sm text-gray-600 dark:text-gray-300">{{ $assignment->subject?->name }}</p>
                                            </div>
                                            <span class="inline-flex items-center rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-800 dark:bg-amber-900/60 dark:text-amber-100">
                                                Due {{ \Carbon\Carbon::parse($assignment->deadline)->format('M d, Y') }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="rounded-2xl border border-dashed border-gray-300 p-6 text-sm text-gray-500 dark:border-gray-600 dark:text-gray-400">
                                No pending assignments right now.
                            </div>
                        @endif
                    </div>

                    <div class="rounded-3xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                        <div class="mb-4 flex items-center justify-between">
                            <div>
                                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Overdue assignments</h2>
                                <p class="text-sm text-gray-500 dark:text-gray-400">The next 3 items that are now past due.</p>
                            </div>
                            <a href="{{ route('subjects.menu') }}" class="rounded-lg border border-gray-200 px-3 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-700">
                                View all
                            </a>
                        </div>

                        @if ($overdueAssignments->isNotEmpty())
                            <div class="space-y-3">
                                @foreach ($overdueAssignments as $assignment)
                                    <div class="rounded-2xl border border-rose-100 bg-rose-50 p-4 dark:border-rose-900/60 dark:bg-rose-950/30">
                                        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                                            <div>
                                                <p class="font-semibold text-gray-900 dark:text-white">{{ $assignment->title }}</p>
                                                <p class="text-sm text-gray-600 dark:text-gray-300">{{ $assignment->subject?->name }}</p>
                                            </div>
                                            <span class="inline-flex items-center rounded-full bg-rose-100 px-3 py-1 text-xs font-semibold text-rose-800 dark:bg-rose-900/60 dark:text-rose-100">
                                                Due {{ \Carbon\Carbon::parse($assignment->deadline)->format('M d, Y') }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="rounded-2xl border border-dashed border-gray-300 p-6 text-sm text-gray-500 dark:border-gray-600 dark:text-gray-400">
                                No overdue assignments right now.
                            </div>
                        @endif
                    </div>
                </div>

                <div class="rounded-3xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                    <div class="mb-4 flex items-center justify-between">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Assignment overview</h2>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Filter the breakdown by a custom date range.</p>
                        </div>
                    </div>

                    <div class="grid gap-3 sm:grid-cols-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Start date
                            <input id="dashboard-start-date" type="date" class="mt-1 w-full rounded-xl border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </label>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            End date
                            <input id="dashboard-end-date" type="date" class="mt-1 w-full rounded-xl border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </label>
                    </div>

                    <div class="mt-6 flex flex-col items-center gap-5 lg:flex-row lg:items-center lg:justify-between">
                        <div class="relative flex h-52 w-52 items-center justify-center rounded-full border border-gray-200 bg-gray-50 dark:border-gray-600 dark:bg-gray-900/60" id="dashboard-ring-wrapper">
                            <div class="absolute inset-4 rounded-full border border-white/60 dark:border-gray-700"></div>
                            <div class="absolute h-36 w-36 rounded-full bg-white dark:bg-gray-800"></div>
                            <div class="relative z-10 text-center">
                                <p class="text-3xl font-bold text-gray-900 dark:text-white" id="dashboard-total-count">0</p>
                                <p class="text-xs uppercase tracking-[0.25em] text-gray-500 dark:text-gray-400">Assignments</p>
                            </div>
                        </div>

                        <div class="w-full space-y-3">
                            <div class="flex items-center justify-between rounded-xl bg-emerald-50 px-3 py-2 dark:bg-emerald-950/30">
                                <div class="flex items-center gap-2 text-sm text-emerald-700 dark:text-emerald-200">
                                    <span class="h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
                                    Completed
                                </div>
                                <span class="font-semibold" id="completed-count">0</span>
                            </div>
                            <div class="flex items-center justify-between rounded-xl bg-amber-50 px-3 py-2 dark:bg-amber-950/30">
                                <div class="flex items-center gap-2 text-sm text-amber-700 dark:text-amber-200">
                                    <span class="h-2.5 w-2.5 rounded-full bg-amber-500"></span>
                                    Pending
                                </div>
                                <span class="font-semibold" id="pending-count">0</span>
                            </div>
                            <div class="flex items-center justify-between rounded-xl bg-rose-50 px-3 py-2 dark:bg-rose-950/30">
                                <div class="flex items-center gap-2 text-sm text-rose-700 dark:text-rose-200">
                                    <span class="h-2.5 w-2.5 rounded-full bg-rose-500"></span>
                                    Overdue
                                </div>
                                <span class="font-semibold" id="overdue-count">0</span>
                            </div>
                        </div>
                    </div>

                    <p id="dashboard-filter-summary" class="mt-4 text-sm text-gray-500 dark:text-gray-400">
                        Showing all assignments.
                    </p>
                </div>
            </div>
        </div>
    @endif

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const assignments = @json($dashboardAssignments);
                const startInput = document.getElementById('dashboard-start-date');
                const endInput = document.getElementById('dashboard-end-date');
                const ringWrapper = document.getElementById('dashboard-ring-wrapper');
                const totalCount = document.getElementById('dashboard-total-count');
                const completedCount = document.getElementById('completed-count');
                const pendingCount = document.getElementById('pending-count');
                const overdueCount = document.getElementById('overdue-count');
                const summary = document.getElementById('dashboard-filter-summary');

                if (!startInput || !endInput || !ringWrapper || !totalCount || !completedCount || !pendingCount || !overdueCount || !summary) {
                    return;
                }

                function parseDate(value) {
                    return value ? new Date(value + 'T00:00:00') : null;
                }

                function inRange(dateValue) {
                    const date = parseDate(dateValue);
                    const start = parseDate(startInput.value);
                    const end = parseDate(endInput.value);

                    if (!date) {
                        return false;
                    }

                    if (start && date < start) {
                        return false;
                    }

                    if (end && date > end) {
                        return false;
                    }

                    return true;
                }

                function render() {
                    const filtered = assignments.filter((assignment) => inRange(assignment.deadline));
                    const counts = {
                        completed: 0,
                        pending: 0,
                        overdue: 0,
                    };

                    filtered.forEach((assignment) => {
                        if (assignment.status === 'completed') {
                            counts.completed++;
                        } else if (assignment.status === 'overdue') {
                            counts.overdue++;
                        } else {
                            counts.pending++;
                        }
                    });

                    const total = filtered.length;
                    const completedShare = total ? (counts.completed / total) * 100 : 0;
                    const pendingShare = total ? (counts.pending / total) * 100 : 0;
                    const overdueShare = total ? (counts.overdue / total) * 100 : 0;
                    const completedAngle = completedShare;
                    const pendingAngle = pendingShare;
                    const overdueAngle = overdueShare;

                    const completedStop = completedAngle;
                    const pendingStop = completedStop + pendingAngle;
                    const overdueStop = pendingStop + overdueAngle;
                    const gradient = `conic-gradient(
                        #22c55e 0deg ${completedStop * 3.6}deg,
                        #f59e0b ${completedStop * 3.6}deg ${pendingStop * 3.6}deg,
                        #ef4444 ${pendingStop * 3.6}deg ${overdueStop * 3.6}deg
                    )`;

                    ringWrapper.style.background = gradient;
                    totalCount.textContent = total;
                    completedCount.textContent = counts.completed;
                    pendingCount.textContent = counts.pending;
                    overdueCount.textContent = counts.overdue;

                    if (startInput.value || endInput.value) {
                        summary.textContent = 'Showing assignments in the selected date range.';
                    } else {
                        summary.textContent = 'Showing all assignments.';
                    }
                }

                [startInput, endInput].forEach((element) => {
                    element.addEventListener('input', render);
                });

                render();
            });
        </script>
    @endpush
@endsection
