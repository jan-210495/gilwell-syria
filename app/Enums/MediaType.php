<?php

namespace App\Enums;

enum MediaType: string
{
    case Image = 'image';
    case Video = 'video';
    case Document = 'document';

    /**
     * @return array<string, string>
     */
    public static function options(): array
    {
        return [
            self::Image->value => 'Image',
            self::Video->value => 'Video',
            self::Document->value => 'Document',
        ];
    }
}
