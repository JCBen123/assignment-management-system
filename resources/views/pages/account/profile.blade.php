@extends('layouts.app.layout')

@section('title', 'Profile')

@section('content')
    @php
        $joinDate = $user->created_at ? $user->created_at->format('d M Y') : 'N/A';
        $statusPalette = [
            'pending' => 'bg-yellow-400',
            'completed' => 'bg-emerald-500',
            'overdue' => 'bg-red-500',
        ];
        $statusLabels = [
            'pending' => 'Pending',
            'completed' => 'Completed',
            'overdue' => 'Overdue',
        ];
        $maxStatusCount = max($statusCounts['pending'], $statusCounts['completed'], $statusCounts['overdue'], 1);
    @endphp

    <div class="space-y-6">
        <section class="rounded-2xl bg-white dark:bg-gray-800 p-6 shadow-sm">
            <div class="flex flex-col gap-5 md:flex-row md:items-center md:justify-between">
                <div class="flex items-center gap-4">
                    <form method="POST" action="{{ route('profile.picture.upload') }}" enctype="multipart/form-data" class="relative">
                        @csrf

                        <label for="profile_picture" class="group block cursor-pointer">
                            @if ($profileImage)
                                <img src="{{ asset('storage/'.$profileImage->path) }}" alt="Profile picture" class="h-16 w-16 rounded-full object-cover ring-2 ring-sky-200 dark:ring-sky-900">
                            @else
                                <div class="flex h-16 w-16 items-center justify-center rounded-full bg-sky-100 text-2xl font-bold text-sky-700 dark:bg-sky-900/40 dark:text-sky-200">
                                    {{ $user->initials() }}
                                </div>
                            @endif

                            <span class="absolute inset-0 flex items-center justify-center rounded-full bg-black/40 text-white opacity-0 transition-opacity group-hover:opacity-100">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="h-6 w-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.438 1.438 0 1 1 2.034 2.034l-1.683 1.683m-1.688-1.688L7.5 15.5a2 2 0 0 0-.5.9l-.4 1.6a.5.5 0 0 0 .6.6l1.6-.4a2 2 0 0 0 .9-.5l9.7-9.7m-1.688-1.688 1.688 1.688" />
                                </svg>
                            </span>
                        </label>

                        <input id="profile_picture" name="profile_picture" type="file" accept="image/*" class="hidden" onchange="this.form.submit()">
                    </form>

                    <div>
                        <div class="flex gap-2">
                            <h1 class="text-2xl font-bold">{{ $user->name }}</h1>
                            <a href="/personal-info" class="self-end text-sm underline text-blue-400 hover:text-blue-200">Edit</a>
                        </div>
                        <p class="text-sm text-gray-500 dark:text-gray-300">{{ $user->email }}</p>
                    </div>
                </div>
            </div>

            <div class="mt-6 grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                <div class="rounded-xl border border-gray-200 bg-gray-50 p-4 dark:border-gray-700 dark:bg-gray-900/40">
                    <p class="text-sm text-gray-500 dark:text-gray-300">Join date</p>
                    <p class="mt-1 text-lg font-semibold">{{ $joinDate }}</p>
                </div>

                <div class="rounded-xl border border-gray-200 bg-gray-50 p-4 dark:border-gray-700 dark:bg-gray-900/40">
                    <p class="text-sm text-gray-500 dark:text-gray-300">Total subjects added</p>
                    <p class="mt-1 text-lg font-semibold">{{ $totalSubjects }}</p>
                </div>

                <div class="rounded-xl border border-gray-200 bg-gray-50 p-4 dark:border-gray-700 dark:bg-gray-900/40">
                    <p class="text-sm text-gray-500 dark:text-gray-300">Total assignments added</p>
                    <p class="mt-1 text-lg font-semibold">{{ $totalAssignments }}</p>
                </div>
            </div>
        </section>

        <section class="rounded-2xl bg-white dark:bg-gray-800 p-6 shadow-sm">
            <h2 class="text-xl font-semibold">Assignment status overview</h2>

            <div class="mt-6 space-y-4">
                @foreach ($statusLabels as $status => $label)
                    @php
                        $count = $statusCounts[$status] ?? 0;
                        $width = round(($count / $maxStatusCount) * 100, 1);
                    @endphp

                    <div>
                        <div class="mb-1 flex items-center justify-between text-sm">
                            <span class="font-medium">{{ $label }}</span>
                            <span class="text-gray-600 dark:text-gray-300">{{ $count }}</span>
                        </div>

                        <div class="h-3 w-full overflow-hidden rounded-full bg-gray-200 dark:bg-gray-700">
                            <div class="h-3 rounded-full {{ $statusPalette[$status] ?? 'bg-sky-500' }}" style="width: {{ $width }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </div>
@endsection
