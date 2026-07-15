<?php

namespace App\Http\Controllers;

use App\Enums\AssignmentStatus;
use App\Models\Assignments;
use App\Models\Subjects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssignmentController extends Controller
{
    public function index(Request $request, $subject_id)
    {
        $subject = Subjects::where('user_id', Auth::id())->findOrFail($subject_id);

        $query = Assignments::where('subject_id', $subject->id);

        if ($request->filled('keyword')) {
            $keyword = $request->input('keyword');

            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                ->orWhere('code', 'like', "%{$keyword}%");
            });
        }

        $sort = $request->input('sort', 'name');
        $direction = $request->input('direction', 'asc');

        if ($sort === 'recent') {
            $query->orderBy('created_at', $direction);
        } else if ($sort === 'name') {
            $query->orderBy('title', $direction);
        } else {
            $query->orderBy('deadline', $direction);
        }

        $assignments = $query->get();

        return view('pages.assignments.details', compact('subject', 'assignments'));
    }

    public function addAssignment(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'deadline' => ['required', 'date'],
            'remarks' => ['nullable', 'string'],
        ]);

        Assignments::create([
            'subject_id' => $request->input('subject_id'),
            'title' => $validated['title'],
            'deadline' => $validated['deadline'],
            'remarks' => $validated['remarks'] ?? null,
        ]);

        return redirect()->route('subjects.details', ['subject' => $request->input('subject_id')])->with('status', 'Assignment added successfully.');
    }

    public function editAssignment(Request $request)
    {
        $assignment = Assignments::findOrFail($request->input('id'));

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'deadline' => ['required', 'date'],
            'remarks' => ['nullable', 'string'],
        ]);

        $assignment->update([
            'title' => $validated['title'],
            'deadline' => $validated['deadline'],
            'remarks' => $validated['remarks'] ?? null,
        ]);

        return redirect()->route('subjects.details', ['subject' => $assignment->subject_id])->with('status', 'Assignment updated successfully.');
    }

    public function markAsCompleted(Request $request)
    {
        $assignment = Assignments::findOrFail($request->input('id'));

        $assignment->update([
            'status' => AssignmentStatus::COMPLETED->value,
            'completion_date' => now(),
        ]);

        return redirect()->route('subjects.details', ['subject' => $assignment->subject_id])->with('status', 'Assignment marked as completed.');
    }

    public function deleteAssignment(Request $request)
    {
        $assignment = Assignments::findOrFail($request->input('id'));
        $subject_id = $assignment->subject_id;
        $assignment->delete();

        return redirect()->route('subjects.details', ['subject' => $subject_id])->with('status', 'Assignment deleted successfully.');
    }
}