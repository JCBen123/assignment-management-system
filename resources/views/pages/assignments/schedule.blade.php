@extends('layouts.app.layout')

@section('title', 'Schedule')

@section('content')
    @php
        $calendarEvents = $assignments->map(function ($assignment) {
            return [
                'title' => $assignment->title,
                'start' => $assignment->deadline,
                'color' => $assignment->status === \App\Enums\AssignmentStatus::OVERDUE->value
                    ? '#ef4444'
                    : '#facc15',
                'textColor' => '#111827',
                'extendedProps' => [
                    'id' => $assignment->id,
                    'status' => $assignment->status,
                    'subject_name' => $assignment->subject?->name,
                    'deadline' => $assignment->deadline,
                    'remarks' => $assignment->remarks,
                ],
            ];
        })->values()->all();
    @endphp

    <h1 class="text-2xl font-bold mb-3">Schedule</h1>

    <script>
        window.assignmentScheduleEvents = @json($calendarEvents);
    </script>

    @include('components.calendar')
    @include('modals.calendar-assignment-detail-modal')
@endsection
