<?php
namespace App\Enums;

use App\Helpers\EnumHelper;

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
            self::High     => 'warning',
            self::Medium   => 'info',
            self::Low      => 'success',
        };
    }

    public static function toArray(): array
    {
        return EnumHelper::toArray(self::class);
    }
}
