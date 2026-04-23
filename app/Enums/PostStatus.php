<?php

namespace App\Enums;

enum PostStatus : string {
    case Published = 'published';
    case Draft = 'draft';
    case Archived = 'archived';

    public function label() : string
    {
        return match ($this) {
            self::Published => 'Published',
            self::Draft     => 'Draft',
            self::Archived  => 'Archived'
        };
    }

    public static function options() : array{
        return collect(self::cases())
            ->mapWithKeys(fn ($case) => [$case->value => $case->label()])
            ->toArray();
    }
}
