<?php

namespace App\Models;

use App\Enums\AssignmentStatus;
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

    public function subject()
    {
        return $this->belongsTo(Subjects::class);
    }
}