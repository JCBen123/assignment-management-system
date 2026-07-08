<?php

namespace App\Enums;

enum AssignmentNotificationOption: string
{
    case DEADLINE_DAY = 'deadline_day';
    case THREE_DAYS = '3_days';
    case ONE_WEEK = '1_week';
    case TWO_WEEKS = '2_weeks';
    case OVERDUE = 'overdue';
}