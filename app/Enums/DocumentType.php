<?php

declare(strict_types=1);

namespace App\Enums;

enum DocumentType: string
{
    case LESSON_PLAN = 'lesson_plan';
    case FORM = 'form';
    case REPORT = 'report';
    case OTHER = 'other';

    public function label(): string
    {
        return match ($this) {
            self::LESSON_PLAN => 'Lesson Plan',
            self::FORM => 'Form',
            self::REPORT => 'Report',
            self::OTHER => 'Other',
        };
    }
}
