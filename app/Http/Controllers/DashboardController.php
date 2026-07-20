<?php

namespace App\Http\Controllers;

use App\Enums\AssignmentStatus;
use App\Models\Assignments;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $dashboardAssignments = [];
        $urgentPendingAssignments = collect();
        $overdueAssignments = collect();

        if ($user) {
            $dashboardAssignments = Assignments::query()
                ->whereHas('subject', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })
                ->with('subject')
                ->orderBy('deadline', 'asc')
                ->get()
                ->map(function ($assignment) {
                    return [
                        'id' => $assignment->id,
                        'title' => $assignment->title,
                        'status' => $assignment->status,
                        'deadline' => $assignment->deadline,
                        'subject' => $assignment->subject?->name,
                    ];
                })
                ->all();

            $urgentPendingAssignments = Assignments::query()
                ->whereHas('subject', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })
                ->where('status', AssignmentStatus::PENDING->value)
                ->with('subject')
                ->orderBy('deadline', 'asc')
                ->take(3)
                ->get();

            $overdueAssignments = Assignments::query()
                ->whereHas('subject', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })
                ->where('status', AssignmentStatus::OVERDUE->value)
                ->with('subject')
                ->orderBy('deadline', 'asc')
                ->take(3)
                ->get();
        }

        return view('home', [
            'user' => $user,
            'dashboardAssignments' => $dashboardAssignments,
            'urgentPendingAssignments' => $urgentPendingAssignments,
            'overdueAssignments' => $overdueAssignments,
        ]);
    }
}
