<?php

namespace App\Http\Controllers;

use App\Models\Subjects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Subjects::where('user_id', Auth::id())->with('assignments');

        if ($request->filled('keyword')) {
            $keyword = $request->input('keyword');

            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                ->orWhere('code', 'like', "%{$keyword}%");
            });
        }

        $sort = $request->input('sort', 'name');
        $direction = $request->input('direction', 'asc');

        if ($sort === 'recent') {
            $query->orderBy('created_at', $direction);
        } else {
            $query->orderBy('name', $direction);
        }

        $subjects = $query->get();

        return view('pages.assignments.menu', compact('subjects'));
    }

    public function addSubject(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:50'],
            'remarks' => ['nullable', 'string'],
        ]);

        Subjects::create([
            'user_id' => Auth::id(),
            'name' => $validated['name'],
            'code' => $validated['code'] ?? null,
            'remarks' => $validated['remarks'] ?? null,
        ]);

        return redirect()->route('subjects.menu')->with('status', 'Subject added successfully.');
    }

    public function editSubject(Request $request)
    {
        $subject = Subjects::findOrFail($request->input('id'));

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:50'],
            'remarks' => ['nullable', 'string'],
        ]);

        $subject->update([
            'name' => $validated['name'],
            'code' => $validated['code'] ?? null,
            'remarks' => $validated['remarks'] ?? null,
        ]);

        return redirect()->route('subjects.menu')->with('status', 'Subject updated successfully.');
    }

    public function deleteSubject(Request $request)
    {
        $subject = Subjects::findOrFail($request->input('id'));
        $subject->delete();

        return redirect()->route('subjects.menu')->with('status', 'Subject deleted successfully.');
    }
}
