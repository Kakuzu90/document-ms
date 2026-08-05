<?php

declare(strict_types=1);

namespace App\Enums;

enum DocumentStatus: string
{
    case DRAFT = 'draft';
    case SUBMITTED = 'submitted';
    case UNDER_REVIEW = 'under_review';
    case REVIEWED = 'reviewed';
    case NEEDS_REVISION = 'needs_revision';

    public function label(): string
    {
        return match ($this) {
            self::DRAFT => 'Draft',
            self::SUBMITTED => 'Submitted',
            self::UNDER_REVIEW => 'Under Review',
            self::REVIEWED => 'Reviewed',
            self::NEEDS_REVISION => 'Needs Revision',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::DRAFT => 'surface',
            self::SUBMITTED => 'primary',
            self::UNDER_REVIEW => 'warning',
            self::REVIEWED => 'success',
            self::NEEDS_REVISION => 'danger',
        };
    }
}
