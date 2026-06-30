<?php

namespace App\Enums;

enum AssignmentStatus: String
{
    case COMPLETED = 'completed';
    case OVERDUE = 'overdue';
    case PENDING = 'pending';
}