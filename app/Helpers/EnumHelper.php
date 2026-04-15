<?php

namespace App\Helpers;

use UnitEnum;

class EnumHelper
{
    public static function toArray(string $enumClass): array
    {
        return collect($enumClass::cases())
            ->mapWithKeys(fn ($case) => [$case->value => $case->name])
            ->toArray();
    }
}
