<?php

namespace App\Enums;

enum PublishStatus: string
{
    case Draft = 'draft';
    case PendingReview = 'pending_review';
    case Published = 'published';
    case Archived = 'archived';

    /**
     * @return array<string, string>
     */
    public static function options(): array
    {
        return [
            self::Draft->value => 'Draft',
            self::PendingReview->value => 'Pending review',
            self::Published->value => 'Published',
            self::Archived->value => 'Archived',
        ];
    }

    public function label(): string
    {
        return self::options()[$this->value];
    }
}
