<?php

namespace App\Enums;

enum TicketStatusEnum: string
{
    // draft, submitted, in_progress, approved, rejected, cancelled
    case DRAFT = 'draft';
    case SUBMITTED = 'submitted';
    case IN_PROGRESS = 'in_progress';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
    case CANCELLED = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::DRAFT => 'Draft',
            self::SUBMITTED => 'Submitted',
            self::IN_PROGRESS => 'In Progress',
            self::APPROVED => 'Approved',
            self::REJECTED => 'Rejected',
            self::CANCELLED => 'Cancelled',
        };
    }
}
