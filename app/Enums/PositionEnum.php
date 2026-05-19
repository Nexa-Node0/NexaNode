<?php

namespace App\Enums;

enum PositionEnum: string
{
    case FullTime = 'fulltime';
    case PartTime = 'part-time';
    case Contract = 'contract';
    case Internship = 'internship';

    public function label(): string
    {
        return match ($this) {
            self::FullTime => 'FullTime',
            self::PartTime => 'Part-Time',
            self::Contract => 'Contract',
            self::Internship => 'Internship'
        };
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn($case) => [$case->value => $case->label()])
            ->toArray();
    }

    public static function values(): array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }
}
