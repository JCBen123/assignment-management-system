<?php

namespace App\Models;

use App\Enums\AssignmentNotificationOption;
use App\Enums\AssignmentStatus;
use App\Notifications\AssignmentDeadlineNotification;
use Illuminate\Database\Eloquent\Model;

class Assignments extends Model
{
    protected $fillable = [
        'subject_id',
        'title',
        'deadline',
        'completion_date',
        'remarks',
        'status',
    ];

    public static function markPastDueAsOverdue(?int $userId = null): int
    {
        if ($userId === null) {
            return 0;
        }

        return static::query()
            ->whereHas('subject', function ($query) use ($userId): void {
                $query->where('user_id', $userId);
            })
            ->where('status', AssignmentStatus::PENDING->value)
            ->whereDate('deadline', '<', now()->toDateString())
            ->update(['status' => AssignmentStatus::OVERDUE->value]);
    }

    public static function sendDeadlineNotifications(?int $userId = null): int
    {
        if ($userId === null) {
            return 0;
        }

        $user = User::findOrFail($userId);

        $assignments = static::query()
            ->whereHas('subject', function ($query) use ($userId): void {
                $query->where('user_id', $userId);
            })
            ->whereIn('status', [AssignmentStatus::PENDING->value, AssignmentStatus::OVERDUE->value])
            ->with('subject')
            ->get();

        $sent = 0;

        foreach ($assignments as $assignment) {

            $today = \Carbon\Carbon::today();
            $deadline = \Carbon\Carbon::parse($assignment->deadline)->startOfDay();
            $daysUntilDeadline = $today->diffInDays($deadline, false);
            $notificationKind = null;
            $message = null;

            if ($assignment->status == AssignmentStatus::PENDING->value) {
                if ($daysUntilDeadline > 7 && $daysUntilDeadline <= 14) {
                    $notificationKind = AssignmentNotificationOption::TWO_WEEKS;
                    $message = 'Assignment "'.$assignment->title.'" is due in 2 weeks.';
                } elseif ($daysUntilDeadline > 3 && $daysUntilDeadline <= 7) {
                    $notificationKind = AssignmentNotificationOption::ONE_WEEK;
                    $message = 'Assignment "'.$assignment->title.'" is due in 1 week.';
                } elseif ($daysUntilDeadline > 0 && $daysUntilDeadline <= 3) {
                    $notificationKind = AssignmentNotificationOption::THREE_DAYS;
                    $message = 'Assignment "'.$assignment->title.'" is due in 3 days.';
                } elseif ($daysUntilDeadline == 0) {
                    $notificationKind = AssignmentNotificationOption::DEADLINE_DAY;
                    $message = 'Assignment "'.$assignment->title.'" is due today.';
                }
            } else {
                $notificationKind = AssignmentNotificationOption::OVERDUE;
                $message = 'Assignment "'.$assignment->title.'" is overdue.';
            }

            if ($notificationKind === null || $message === null) {
                continue;
            }

            $exists = $user->notifications()
                ->where('data->assignment_id', $assignment->id)
                ->where('data->notification_option', $notificationKind->value)
                ->exists();

            if ($exists) {
                continue;
            }

            $assignment->loadMissing('subject');
            $user->notify(new AssignmentDeadlineNotification(
                kind: $notificationKind,
                title: $assignment->title,
                message: $message,
                assignmentId: $assignment->id,
                deadline: $assignment->deadline,
                subjectName: $assignment->subject->name ?? 'Unknown subject',
            ));

            $sent++;
        }

        return $sent;
    }

    public function subject()
    {
        return $this->belongsTo(Subjects::class);
    }
}
