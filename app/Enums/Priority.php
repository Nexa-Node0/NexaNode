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
            self::High     => 'warning',
            self::Medium   => 'info',
            self::Low      => 'success',
        };
    }
}
