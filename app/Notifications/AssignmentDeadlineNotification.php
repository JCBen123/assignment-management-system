<?php

namespace App\Notifications;

use App\Enums\AssignmentNotificationOption;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AssignmentDeadlineNotification extends Notification
{
    use Queueable;

    public function __construct(
        public AssignmentNotificationOption $type,
        public string $title,
        public string $message,
        public int $assignmentId,
        public string $deadline,
        public string $subjectName,
    ) {
    }

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * @return array<string, mixed>
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'type' => $this->type->value,
            'assignment_id' => $this->assignmentId,
            'title' => $this->title,
            'message' => $this->message,
            'deadline' => $this->deadline,
            'subject' => $this->subjectName,
        ];
    }
}
