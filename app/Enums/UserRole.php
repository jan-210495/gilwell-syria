<?php

namespace App\Enums;

enum UserRole: string
{
    case Admin = 'admin';
    case Editor = 'editor';

    /**
     * @return array<string, string>
     */
    public static function options(): array
    {
        return [
            self::Admin->value => 'Admin',
            self::Editor->value => 'Editor',
        ];
    }

    public function label(): string
    {
        return self::options()[$this->value];
    }

    public function canAccessFilament(): bool
    {
        return match ($this) {
            self::Admin, self::Editor => true,
        };
    }
}
