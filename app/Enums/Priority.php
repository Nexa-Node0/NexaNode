<?php
namespace App\Enums;

enum Priority: string {
    //
    case Critical = 'critical';
    case High     = 'high';
    case Medium   = 'medium';
    case Low      = 'low';

    public function color(): string
    {
        return match ($this) {
            self::Critical => 'danger',
            self::High     => 'danger',
            self::Medium   => 'warning',
            self::Low      => 'info',
            default        => 'gray'
        };
    }

    public function icon(): string
    {
        return 'heroicon-m-' . match ($this) {
            self::Critical => 'exclamation-triangle',
            self::High     => 'arrow-up-circle',
            self::Medium   => 'minus-circle',
            self::Low      => 'arrow-down-circle',
            default        => 'minus-circle'
        };
    }

    public function label(): string
    {
        $string = $this->name;

        $re    = '/(?<=[a-z])(?=[A-Z])|(?<=[A-Z])(?=[A-Z][a-z])/';
        $parts = preg_split($re, $string);

        return ucwords(implode(' ', $parts));
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn($case) => [$case->value => $case->label()])
            ->toArray();
    }
}
