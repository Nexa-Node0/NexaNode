<?php
namespace App\Enums;

enum ApprovedStatus: string {
    case Approved = 'approved';
    case Pending  = 'pending';
    case Rejected = 'rejected';

    public function label(): string
    {
        $string = $this->name;

        $re    = '/(?<=[a-z])(?=[A-Z])|(?<=[A-Z])(?=[A-Z][a-z])/';
        $parts = preg_split($re, $string);

        return ucwords(implode(' ', $parts));
    }

    public function color(): string
    {
        return match ($this) {
            self::Approved => 'success',
            self::Pending  => 'info',
            self::Rejected => 'danger',
            default        => 'danger',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::Approved => 'heroicon-m-check-circle',
            self::Pending  => 'heroicon-m-clock',
            self::Rejected => 'heroicon-m-x-circle',
            default        => 'heroicon-m-minus-circle'
        };
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn($case) => [$case->value => $case->label()])
            ->toArray();
    }
}
