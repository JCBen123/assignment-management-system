<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function markAsRead(Request $request, DatabaseNotification $notification): RedirectResponse
    {
        if ($notification->notifiable_id !== Auth::id()) {
            abort(403);
        }

        if (is_null($notification->read_at)) {
            $notification->markAsRead();
        }

        return redirect()->back();
    }

    public function markAllAsRead(Request $request): RedirectResponse
    {
        $user = Auth::user();

        if ($user === null) {
            abort(403);
        }

        $user->unreadNotifications->each(function (DatabaseNotification $notification): void {
            $notification->markAsRead();
        });

        return redirect()->back();
    }
}
