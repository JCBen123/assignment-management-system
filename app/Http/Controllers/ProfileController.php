<?php

namespace App\Http\Controllers;

use App\Enums\AssignmentStatus;
use App\Models\Assignments;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function mount()
    {
        $user = User::findOrFail(Auth::id());

        $totalSubjects = $user->subjects()->count();
        $totalAssignments = Assignments::query()
            ->whereHas('subject', function ($query) use ($user): void {
                $query->where('user_id', $user->id);
            })
            ->count();

        $statusCounts = [
            'pending' => Assignments::query()
                ->whereHas('subject', function ($query) use ($user): void {
                    $query->where('user_id', $user->id);
                })
                ->where('status', AssignmentStatus::PENDING->value)
                ->count(),
            'completed' => Assignments::query()
                ->whereHas('subject', function ($query) use ($user): void {
                    $query->where('user_id', $user->id);
                })
                ->where('status', AssignmentStatus::COMPLETED->value)
                ->count(),
            'overdue' => Assignments::query()
                ->whereHas('subject', function ($query) use ($user): void {
                    $query->where('user_id', $user->id);
                })
                ->where('status', AssignmentStatus::OVERDUE->value)
                ->count(),
        ];

        $profileImage = $user->media()->latest()->first();

        return view('pages.account.profile', [
            'user' => $user,
            'totalSubjects' => $totalSubjects,
            'totalAssignments' => $totalAssignments,
            'statusCounts' => $statusCounts,
            'profileImage' => $profileImage,
        ]);
    }

    public function uploadProfilePicture(Request $request)
    {
        $validated = $request->validate([
            'profile_picture' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $user = User::findOrFail(Auth::id());
        $path = $request->file('profile_picture')->store('profile-pictures', 'public');

        $user->media()->delete();

        $user->media()->create([
            'file_name' => basename($path),
            'mime_type' => $validated['profile_picture']->getClientMimeType(),
            'path' => $path,
            'size' => $validated['profile_picture']->getSize(),
        ]);

        return back()->with('status', 'Profile picture updated successfully.');
    }
}
